<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'price' => $this->faker->numberBetween(2, 20),
            'description' => $this->faker->text,
            'stock' => $this->faker->numberBetween(2, 305),
            'image' => 'storage/images/' . $this->faker->image('public/storage/images', 300, 300, null, false),
        ];
    }
}
