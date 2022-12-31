<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductreviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => function(){
                return Product::all()->random();
            },
            'user_id' => function(){
                return User::all()->random();
            },
            'customer' => $this->faker->name,
            'review' => $this->faker->paragraph,
            'star' => $this->faker->numberBetween(0,5)
        ];
    }
}
