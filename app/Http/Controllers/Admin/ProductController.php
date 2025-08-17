<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString() ?: null;

        $products = Product::query()
            ->with('category:id,name')
            ->when($q, fn($qq) => $qq->where(function($x) use ($q) {
                $x->where('name', 'like', "%$q%")
                  ->orWhere('slug', 'like', "%$q%");
            }))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();
        $products->getCollection()->transform(function ($product) {
            return $product->fresh(['category']);
        });

        return view('admin.products.index', compact('products', 'q'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->pluck('name','id');
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'name'        => ['required','string','max:255'],
            'slug'        => ['nullable','string','max:255','unique:products,slug'],
            'description' => ['nullable','string'],
            'base_price'  => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'image'       => ['nullable','image','mimes:jpeg,jpg,png,webp,gif','max:4096'],

            'variants'                 => ['array'],
            'variants.*.option_name'   => ['nullable','string','max:255'],
            'variants.*.option_value'  => ['nullable','string','max:255'],
            'variants.*.sku'           => ['nullable','string','max:255'],
            'variants.*.price'         => ['nullable','numeric','min:0'],
            'variants.*.stock'         => ['nullable','integer','min:0'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name'].'-'.Str::random(6));
        $newImagePath = null;
        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('products', 'public'); // storage/app/public/products/...
            $data['image'] = $newImagePath;
        }

        try {
            DB::transaction(function () use ($data) {
                $variants = $data['variants'] ?? [];
                unset($data['variants']);

                $product = Product::create($data);

                $rows = [];
                foreach ($variants as $v) {
                    if (empty($v['option_name']) && empty($v['option_value']) && empty($v['sku'])) continue;
                    $rows[] = [
                        'product_id'   => $product->id,
                        'sku'          => $v['sku'] ?? Str::upper(Str::random(10)),
                        'option_name'  => $v['option_name'] ?? null,
                        'option_value' => $v['option_value'] ?? null,
                        'price'        => $v['price'] ?? null,
                        'stock'        => $v['stock'] ?? 0,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
                if ($rows) ProductVariant::insert($rows);
            });
        } catch (\Throwable $e) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }
            throw $e;
        }

        return redirect()->route('product.index')->with('success', 'Product created');
    }

    public function edit(Product $product)
    {
        $product->load('variants');
        $categories = Category::orderBy('name')->pluck('name','id');
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'name'        => ['required','string','max:255'],
            'slug'        => ['nullable','string','max:255', Rule::unique('products','slug')->ignore($product->id)],
            'description' => ['nullable','string'],
            'base_price'  => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'image'       => ['nullable','image','mimes:jpeg,jpg,png,webp,gif','max:4096'],

            'variants'                 => ['array'],
            'variants.*.id'            => ['nullable','integer','exists:product_variants,id'],
            'variants.*.option_name'   => ['nullable','string','max:255'],
            'variants.*.option_value'  => ['nullable','string','max:255'],
            'variants.*.sku'           => ['nullable','string','max:255'],
            'variants.*.price'         => ['nullable','numeric','min:0'],
            'variants.*.stock'         => ['nullable','integer','min:0'],
            'delete_variant_ids'       => ['array'],
            'delete_variant_ids.*'     => ['integer','exists:product_variants,id'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name'].'-'.Str::random(6));

        $newImagePath = null;
        $oldImagePath = $product->image;
        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $newImagePath;
        }

        try {
            DB::transaction(function () use ($data, $product) {
                $variants  = $data['variants'] ?? [];
                $deleteIds = $data['delete_variant_ids'] ?? [];
                unset($data['variants'], $data['delete_variant_ids']);
                $product->update($data);
                try {
                    Cache::flush();
                } catch (\Exception $e) {
                    \Log::warning('Cache flush failed: ' . $e->getMessage());
                }

                try {
                    if (function_exists('opcache_reset')) {
                        opcache_reset();
                    }
                } catch (\Exception $e) {
                    \Log::warning('OPCache reset failed: ' . $e->getMessage());
                }
                $product->refresh();

                $cacheKeys = [
                    'product_' . $product->id,
                    'products_list',
                    'products_page_1',
                    'products_search_' . md5($product->name ?? ''),
                ];
                foreach ($cacheKeys as $key) {
                    Cache::forget($key);
                }

                if ($deleteIds) {
                    ProductVariant::where('product_id', $product->id)
                        ->whereIn('id', $deleteIds)->delete();
                }
                foreach ($variants as $v) {
                    if (empty($v['option_name']) && empty($v['option_value']) && empty($v['sku'])) {
                        continue;
                    }

                    if (isset($v['id']) && !empty($v['id']) && is_numeric($v['id'])) {
                        ProductVariant::where('id', $v['id'])
                            ->where('product_id', $product->id)
                            ->update([
                                'option_name'  => $v['option_name'] ?? null,
                                'option_value' => $v['option_value'] ?? null,
                                'sku'          => $v['sku'] ?? Str::upper(Str::random(10)),
                                'price'        => $v['price'] ?? null,
                                'stock'        => $v['stock'] ?? 0,
                                'updated_at'   => now(),
                            ]);
                    } else {
                        ProductVariant::create([
                            'product_id'   => $product->id,
                            'option_name'  => $v['option_name'] ?? null,
                            'option_value' => $v['option_value'] ?? null,
                            'sku'          => $v['sku'] ?? Str::upper(Str::random(10)),
                            'price'        => $v['price'] ?? null,
                            'stock'        => $v['stock'] ?? 0,
                        ]);
                    }
                }
            });
        } catch (\Throwable $e) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }
            throw $e;
        }

        if ($newImagePath && $oldImagePath && $oldImagePath !== $newImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()->route('product.index')->with('success', 'Product updated');
    }

    public function destroy(Product $product)
    {
        $oldImagePath = $product->image;

        $product->delete();

        if ($oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return back()->with('success', 'Product deleted');
    }
}
