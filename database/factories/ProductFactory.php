<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
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
            'user_id' => function(){
                return User::all()->random();
            },
            'category_name' => $this->faker->randomElement(['Electronic','Food','Motor','Kitchen']),
            'description'  => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'encodedKey'=> $this->faker->uuid(),
            'product_name'=> $this->faker->company(),
            'product_price'=> $this->faker->randomNumber(3),
            'product_image' => $this->faker->imageUrl($width = 640, $height = 480)
        ];
    }
}
