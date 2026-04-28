<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    public function definition()
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numerify('###'),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 15, 300),
            'stock' => $this->faker->numberBetween(0, 50),
            'image' => null,
            'featured' => $this->faker->boolean(25),
        ];
    }
}
