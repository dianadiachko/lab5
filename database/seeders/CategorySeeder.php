<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Квартири', 'slug' => 'kvartyry'],
            ['name' => 'Будинки', 'slug' => 'budynky'],
            ['name' => 'Таунхауси', 'slug' => 'taunkhausy'],
            ['name' => 'Земельні ділянки', 'slug' => 'zemelni-dilianky'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']]
            );
        }
    }
}
