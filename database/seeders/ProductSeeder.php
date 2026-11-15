<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');

        //12 основних оголошень
        $products = [
            [
                'slug' => 'svitla-kvartyra-bilia-parku',
                'title' => 'Світла квартира біля парку',
                'category' => 'kvartyry',
                'price' => 1850000,
                'area' => 65,
                'rooms' => 2,
            ],
            [
                'slug' => 'prostora-kvartyra-z-remontom',
                'title' => 'Простора квартира з ремонтом',
                'category' => 'kvartyry',
                'price' => 2400000,
                'area' => 82,
                'rooms' => 3,
            ],
            [
                'slug' => 'kvartyra-z-panoramnymy-viknamy',
                'title' => 'Квартира з панорамними вікнами',
                'category' => 'kvartyry',
                'price' => 3200000,
                'area' => 95,
                'rooms' => 3,
            ],
            [
                'slug' => 'suchasnyi-budynok-z-terasoiu',
                'title' => 'Сучасний будинок із терасою',
                'category' => 'budynky',
                'price' => 4800000,
                'area' => 180,
                'rooms' => 5,
            ],
            [
                'slug' => 'budynok-iz-vlasnym-podviriam',
                'title' => 'Будинок із власним подвір’ям',
                'category' => 'budynky',
                'price' => 3900000,
                'area' => 145,
                'rooms' => 4,
            ],
            [
                'slug' => 'zamiskyi-budynok-iz-sadom',
                'title' => 'Заміський будинок із садом',
                'category' => 'budynky',
                'price' => 5600000,
                'area' => 210,
                'rooms' => 5,
            ],
            [
                'slug' => 'zatyshnyi-taunkhaus-dlia-rodyny',
                'title' => 'Затишний таунхаус для родини',
                'category' => 'taunkhausy',
                'price' => 3500000,
                'area' => 120,
                'rooms' => 4,
            ],
            [
                'slug' => 'taunkhaus-iz-harazhem',
                'title' => 'Таунхаус із гаражем',
                'category' => 'taunkhausy',
                'price' => 4200000,
                'area' => 135,
                'rooms' => 4,
            ],
            [
                'slug' => 'dvopoverkhovyi-taunkhaus',
                'title' => 'Дворівневий таунхаус',
                'category' => 'taunkhausy',
                'price' => 3750000,
                'area' => 128,
                'rooms' => 4,
            ],
            [
                'slug' => 'zemelna-dilianka-bilia-lisu',
                'title' => 'Земельна ділянка біля лісу',
                'category' => 'zemelni-dilianky',
                'price' => 1450000,
                'area' => 800,
                'rooms' => 0,
            ],
            [
                'slug' => 'dilianka-pid-zabudovu',
                'title' => 'Земельна ділянка під забудову',
                'category' => 'zemelni-dilianky',
                'price' => 1100000,
                'area' => 600,
                'rooms' => 0,
            ],
            [
                'slug' => 'dilianka-dlia-pryvatnoho-budynku',
                'title' => 'Ділянка для приватного будинку',
                'category' => 'zemelni-dilianky',
                'price' => 1750000,
                'area' => 1000,
                'rooms' => 0,
            ],
        ];

        foreach ($products as $item) {
            $category = $categories->get($item['category']);

            if (!$category) {
                continue;
            }

            for ($variant = 1; $variant <= 3; $variant++) {
                $slug = $variant === 1
                    ? $item['slug']
                    : $item['slug'] . '-test-' . $variant;

                $title = $variant === 1
                    ? $item['title']
                    : $item['title'] . ' — варіант ' . $variant;

                $price = $item['price'] + (($variant - 1) * 100000);

                Product::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'title' => $title,
                        'category_id' => $category->id,
                        'operation' => 'Продаж',
                        'price' => $price,
                        'currency' => '₴',
                        'short_description' => $title
                            . ' — чудовий варіант для придбання.',
                        'description' => $title
                            . '. Площа об’єкта: '
                            . $item['area']
                            . ' м². Зв’яжіться з нами для уточнення деталей та організації перегляду.',
                        'contact_name' => 'Відділ продажу',
                        'contact_phone' => '+380501234567',
                        'contact_email' => 'sales@example.com',
                        'status' => 'published',
                        'published_at' => '2026-10-01',
                        'attributes' => [
                            'area' => $item['area'],
                            'rooms' => $item['rooms'],
                        ],
                    ]
                );
            }
        }
    }
}
