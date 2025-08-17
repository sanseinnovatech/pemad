@extends('layouts.app')
@section('title','Edit Product')

@section('content')
<div class="section-header"><h1>Edit Product</h1></div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
    <strong>Whoops!</strong> Please fix the following:
    <ul class="mb-0">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header"><h4>Main</h4></div>
        <div class="card-body">
          <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
              @foreach($categories as $id => $name)
                <option value="{{ $id }}" @selected(old('category_id', $product->category_id) == $id)>{{ $name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
          </div>

          <div class="form-group">
            <label>Slug <small class="text-muted">(optional)</small></label>
            <input name="slug" class="form-control" value="{{ old('slug', $product->slug) }}">
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Base Price</label>
              <input type="number" step="0.01" min="0" name="base_price" class="form-control"
                     value="{{ old('base_price', $product->base_price) }}" required>
            </div>
            <div class="form-group col-md-6">
              <label>Stock</label>
              <input type="number" min="0" name="stock" class="form-control"
                     value="{{ old('stock', $product->stock) }}" required>
            </div>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4>Variants</h4>
          <div>
            <button type="button" class="btn btn-sm btn-primary" onclick="addVariantRow()">
              <i class="fas fa-plus"></i> Add Variant
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table mb-0" id="variants-table">
              <thead>
                <tr>
                  <th style="width:16%">Option</th>
                  <th>Value</th>
                  <th>SKU</th>
                  <th style="width:16%">Price</th>
                  <th style="width:12%">Stock</th>
                  <th style="width:8%"></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>

    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-header"><h4>Image</h4></div>
        <div class="card-body">
          <div class="form-group">
            <div class="mb-2 text-center">
              <img
                id="imagePreview"
                alt="Preview"
                class="img-fluid rounded border"
                style="max-height:240px;width:100%;object-fit:contain;background:#f8f9fa;{{ $product->image_url ? '' : 'display:none;' }}"
                src="{{ $product->image_url ?? '' }}"
              >
            </div>

            <input
              type="file"
              name="image"
              id="imageInput"
              class="form-control-file"
              accept="image/*"
            >
            <small class="form-text text-muted">
              Format: JPG, PNG, WEBP, GIF. Maks 4 MB. Biarkan kosong jika tidak ingin mengganti.
            </small>

            <div class="mt-2 d-flex gap-2">
              <button type="button" id="btnClearImage" class="btn btn-sm btn-outline-secondary">Clear</button>
              @if($product->image_url)
                <a href="{{ $product->image_url }}" target="_blank" class="btn btn-sm btn-outline-info">Open</a>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <a href="{{ route('product.index') }}" class="btn btn-secondary">Back</a>
          <button class="btn btn-primary float-right">Update</button>
        </div>
      </div>
    </div>
  </div>
</form>

<template id="variant-row-tpl">
<tr>
  <td>
    <input type="hidden" name="__NAME__[id]" value="">
    <select class="form-control" name="__NAME__[option_name]">
      <option value="">-</option>
      <option>Color</option>
      <option>Size</option>
      <option>Style</option>
      <option>Material</option>
    </select>
  </td>
  <td><input class="form-control" name="__NAME__[option_value]"></td>
  <td><input class="form-control" name="__NAME__[sku]"></td>
  <td><input type="number" step="0.01" min="0" class="form-control" name="__NAME__[price]"></td>
  <td><input type="number" min="0" class="form-control" name="__NAME__[stock]" value="0"></td>
  <td class="text-right">
    <button type="button" class="btn btn-sm btn-danger" onclick="removeVariantRow(this)"><i class="fas fa-trash"></i></button>
  </td>
</tr>
</template>

@php
  $existing = $product->variants->map(function ($v) {
      return [
          'id'           => $v->id,
          'option_name'  => $v->option_name,
          'option_value' => $v->option_value,
          'sku'          => $v->sku,
          'price'        => $v->price,
          'stock'        => $v->stock,
      ];
  })->values()->toArray();
@endphp

@push('scripts')
<script>
let vIndex = 0;

function addVariantRow(prefill = null){
  const tpl = document.querySelector('#variant-row-tpl').innerHTML;
  const name = `variants[${vIndex++}]`;
  const tmp = document.createElement('tbody');
  tmp.innerHTML = tpl.replaceAll('__NAME__', name);
  const row = tmp.firstElementChild;

  if(prefill){
    row.querySelector(`[name="${name}[id]"]`).value            = prefill.id ?? '';
    row.querySelector(`[name="${name}[option_name]"]`).value   = prefill.option_name ?? '';
    row.querySelector(`[name="${name}[option_value]"]`).value  = prefill.option_value ?? '';
    row.querySelector(`[name="${name}[sku]"]`).value           = prefill.sku ?? '';
    row.querySelector(`[name="${name}[price]"]`).value         = prefill.price ?? '';
    row.querySelector(`[name="${name}[stock]"]`).value         = prefill.stock ?? 0;
  }

  document.querySelector('#variants-table tbody').appendChild(row);
}

function removeVariantRow(btn){
  const tr = btn.closest('tr');
  const idInput = tr.querySelector('input[name$="[id]"]');
  if(idInput && idInput.value){
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'delete_variant_ids[]';
    hidden.value = idInput.value;
    document.forms[0].appendChild(hidden);
  }
  tr.remove();
}

const existing = @json($existing);
if(existing.length === 0){
  addVariantRow();
} else {
  existing.forEach(v => addVariantRow(v));
}

const imageInput       = document.getElementById('imageInput');
const imagePreview     = document.getElementById('imagePreview');
const btnClear         = document.getElementById('btnClearImage');
const originalImageUrl = @json($product->image_url);

imageInput.addEventListener('change', function (e) {
  const file = e.target.files && e.target.files[0] ? e.target.files[0] : null;
  if (!file) {
    resetPreview();
    return;
  }
  if (!file.type.startsWith('image/')) {
    alert('File harus berupa gambar.');
    imageInput.value = '';
    resetPreview();
    return;
  }
  const url = URL.createObjectURL(file);
  imagePreview.src = url;
  imagePreview.style.display = 'block';
});

btnClear.addEventListener('click', function(){
  imageInput.value = '';
  resetPreview();
});

function resetPreview(){
  if (originalImageUrl) {
    imagePreview.src = originalImageUrl;
    imagePreview.style.display = 'block';
  } else {
    imagePreview.removeAttribute('src');
    imagePreview.style.display = 'none';
  }
}
</script>
@endpush
@endsection
