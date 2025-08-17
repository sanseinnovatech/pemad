<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Electronics','Computers','Smartphones','Cameras','Audio','Gaming',
            'Home Appliances','Kitchen','Furniture','Office',
            'Sports','Outdoor','Fashion','Shoes','Accessories',
            'Beauty','Health','Baby','Toys','Automotive',
            'Books','Groceries','Pet Supplies','Garden','Tools',
            'Stationery','Art & Craft','Musical Instruments','Software','Networking',
            'Lighting','Storage','Wearables','Smart Home','Photography',
            'Video','Drones','Printers','Monitors','Components',
            'Bags','Watches','Jewelry','Travel','Fitness',
            'Cycling','Motorcycle','Car Care','Cleaning','Security'
        ];

        $rows = [];
        $now = now();
        foreach ($names as $n) {
            $rows[] = [
                'name' => $n,
                'slug' => Str::slug($n),
                'parent_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('categories')->insert($rows);
    }
}
