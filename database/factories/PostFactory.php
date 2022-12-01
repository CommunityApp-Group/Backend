<?php

namespace Database\Factories;

use App\Models\Post;
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

            'category_name' => $this->faker->word,
            'postline'  => $this->faker->text(300),
            'encodedKey'=> $this->faker->unique()->randomNumber(),
            'user_id'=> '2',
            'post_image' => $this->faker->imageUrl($width = 200, $height = 200)
        ];
    }

    public function untitled()
    {
        return $this->state([
            'title' => 'untitled'
        ]);
    }
}
