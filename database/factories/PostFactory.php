<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

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
            'post'  => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'post_image' => $this->faker->imageUrl($width = 640, $height = 480)
        ];
    }


}
