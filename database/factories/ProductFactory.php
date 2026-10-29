<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $products = [
            'Rice' => 65,
            'Wheat Flour' => 45,
            'Sugar' => 50,
            'Salt' => 25,
            'Cooking Oil' => 160,
            'Toor Dal' => 140,
            'Moong Dal' => 130,
            'Chana Dal' => 90,
            'Tea Powder' => 250,
            'Coffee Powder' => 350,
            'Milk' => 30,
            'Curd' => 40,
            'Bread' => 40,
            'Eggs' => 7,
            'Potatoes' => 35,
            'Onions' => 40,
            'Tomatoes' => 30,
            'Apples' => 150,
            'Bananas' => 60,
            'Biscuits' => 30,
        ];

        $name = fake()->unique()->randomElement(array_keys($products));

        return [
            'name' => $name,
            'code' => fake()->unique()->bothify('GRC-####'),
            'price' => $products[$name],
            'tax_percentage' => fake()->randomElement([0, 5, 12]),
            'stock_on_hand' => fake()->numberBetween(10, 100),
        ];
    }
}
