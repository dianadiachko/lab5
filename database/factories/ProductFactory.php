<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Світла квартира біля парку',
            'Сучасний будинок із терасою',
            'Затишний таунхаус для родини',
            'Земельна ділянка під забудову',
            'Простора квартира з ремонтом',
            'Будинок із власним подвір’ям',
            'Дворівнева квартира в новобудові',
            'Таунхаус із гаражем',
            'Ділянка біля лісу',
            'Квартира з панорамними вікнами',
            'Заміський будинок із садом',
            'Ділянка для приватного будинку',
        ]);

        return [
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'title' => $title,
            'category_id' => Category::factory(),
            'operation' => 'Продаж',
            'price' => fake()->numberBetween(1100000, 7200000),
            'currency' => '₴',
            'short_description' => fake()->sentence(10),
            'description' => fake()->paragraphs(3, true),
            'image' => null,
            'contact_name' => fake()->name(),
            'contact_phone' => '+380' . fake()->numerify('#########'),
            'contact_email' => fake()->safeEmail(),
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'attributes' => [
                'rooms' => fake()->numberBetween(1, 6),
                'area' => fake()->numberBetween(35, 250),
                'district' => fake()->randomElement([
                    'Печерський',
                    'Шевченківський',
                    'Голосіївський',
                    'Оболонський',
                ]),
            ],
        ];
    }
}

