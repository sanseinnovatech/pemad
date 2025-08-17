<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BigCatalogSeeder extends Seeder
{
    const TOTAL_PRODUCTS           = 100_000;
    const AVG_VARIANTS_PER_PRODUCT = 3;
    const AVG_REVIEWS_PER_PRODUCT  = 2;

    const BATCH_PRODUCTS = 2_000;
    const CHUNK_INSERT   = 1_000;

    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $categoryIds = DB::table('categories')
            ->pluck('id')
            ->map(fn($v) => (int) $v)
            ->filter()
            ->values()
            ->all();
        if (!count($categoryIds)) {
            throw new \RuntimeException('Categories kosong. Jalankan CategorySeeder dulu.');
        }
        $userIds = DB::table('users')->inRandomOrder()->limit(10_000)->pluck('id')->all();
        if (empty($userIds)) {
            throw new \RuntimeException('Users kosong. Butuh minimal 1 user untuk reviews.');
        }

        DB::disableQueryLog();

        $now = now();
        $productsInserted = 0;

        while ($productsInserted < self::TOTAL_PRODUCTS) {
            $toMake = min(self::BATCH_PRODUCTS, self::TOTAL_PRODUCTS - $productsInserted);

            DB::beginTransaction();
            try {
                $products = [];
                for ($i = 0; $i < $toMake; $i++) {
                    $name  = $faker->unique()->words(mt_rand(2,4), true) . ' ' . Str::upper(Str::random(4));
                    $desc  = $faker->paragraphs(mt_rand(1,3), true);
                    $price = $faker->numberBetween(50_000, 25_000_000) / 100; // 500 - 250000

                    $catId = $categoryIds[array_rand($categoryIds)];
                    if (!$catId) {
                        throw new \RuntimeException('category_id gagal di-generate');
                    }

                    $products[] = [
                        'category_id'  => (int) $catId,
                        'name'         => $name,
                        'slug'         => Str::slug($name.'-'.Str::random(6)),
                        'description'  => $desc,
                        'base_price'   => $price,
                        'stock'        => $faker->numberBetween(0, 500),
                        'rating_avg'   => 0,
                        'rating_count' => 0,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ];
                }

                DB::table('products')->insert($products);


                $maxId   = (int) DB::table('products')->max('id');
                $firstId = $maxId - $toMake + 1;
                $lastId  = $maxId;

                $variants  = [];
                $reviews   = [];
                $ratingAgg = [];

                for ($pid = $firstId; $pid <= $lastId; $pid++) {
                    $numVar = max(1, (int) round($this->randAround(self::AVG_VARIANTS_PER_PRODUCT)));
                    for ($v = 0; $v < $numVar; $v++) {
                        $optName = $faker->randomElement(['Color','Size','Style','Material']);
                        $optVal  = match ($optName) {
                            'Color'    => $faker->safeColorName(),
                            'Size'     => $faker->randomElement(['S','M','L','XL','XXL']),
                            'Style'    => $faker->randomElement(['Basic','Pro','Premium']),
                            'Material' => $faker->randomElement(['Cotton','Leather','Plastic','Metal']),
                            default    => 'Std'
                        };

                        $variants[] = [
                            'product_id'   => $pid,
                            'sku'          => strtoupper(Str::random(10)),
                            'option_name'  => $optName,
                            'option_value' => $optVal,
                            'price'        => (mt_rand(0, 100) < 25) ? $faker->randomFloat(2, 1, 2500) : null, // 25% override
                            'stock'        => $faker->numberBetween(0, 200),
                            'created_at'   => $now,
                            'updated_at'   => $now,
                        ];
                    }

                    $numRev = max(0, (int) round($this->randAround(self::AVG_REVIEWS_PER_PRODUCT)));
                    for ($r = 0; $r < $numRev; $r++) {
                        $rating = $faker->numberBetween(1,5);
                        $uid    = $userIds[array_rand($userIds)];

                        $reviews[] = [
                            'product_id' => $pid,
                            'user_id'    => $uid,
                            'rating'     => $rating,
                            'title'      => $faker->sentence(4),
                            'content'    => $faker->sentences(mt_rand(1,3), true),
                            'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                            'updated_at' => $now,
                        ];

                        $ratingAgg[$pid] = $ratingAgg[$pid] ?? [0,0];
                        $ratingAgg[$pid][0] += $rating;
                        $ratingAgg[$pid][1] += 1;
                    }
                }

                foreach (array_chunk($variants, self::CHUNK_INSERT) as $chunk) {
                    if ($chunk) DB::table('product_variants')->insert($chunk);
                }
                foreach (array_chunk($reviews, self::CHUNK_INSERT) as $chunk) {
                    if ($chunk) DB::table('reviews')->insert($chunk);
                }

                $updates = [];
                foreach ($ratingAgg as $pid => [$sum, $cnt]) {
                    $avg = $cnt ? round($sum / $cnt, 2) : 0;
                    $updates[] = [
                        'id'           => (int) $pid,
                        'rating_avg'   => (float) $avg,
                        'rating_count' => (int) $cnt,
                    ];
                }

                foreach (array_chunk($updates, self::CHUNK_INSERT) as $chunk) {
                    if (empty($chunk)) continue;

                    $ids = array_map(fn($r) => (int)$r['id'], $chunk);
                    $idsList = implode(',', $ids);

                    $caseAvg = 'CASE id ' .
                        implode(' ', array_map(fn($r) => 'WHEN '.(int)$r['id'].' THEN '.(float)$r['rating_avg'], $chunk))
                        . ' END';

                    $caseCnt = 'CASE id ' .
                        implode(' ', array_map(fn($r) => 'WHEN '.(int)$r['id'].' THEN '.(int)$r['rating_count'], $chunk))
                        . ' END';

                    $ts = $now->toDateTimeString();

                    DB::statement("
                        UPDATE products
                        SET rating_avg   = $caseAvg,
                            rating_count = $caseCnt,
                            updated_at   = ?
                        WHERE id IN ($idsList)
                    ", [$ts]);
                }

                DB::commit();

                $faker->unique(true);

                $productsInserted += $toMake;
                $this->command?->info("Inserted products: {$productsInserted}/".self::TOTAL_PRODUCTS);
            } catch (\Throwable $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }

    private function randAround(float $mean): float
    {
        return max(0, $mean + (mt_rand() / mt_getrandmax() - 0.5) * 2); // mean ±1
    }
}
