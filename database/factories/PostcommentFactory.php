<?php

namespace Database\Factories;

use App\Models\Postcomment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostcommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Postcomment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function(){return User::all()->random();},
            'post_id' => function(){return Post::all()->random();},
            'post'  => $this->faker->realText($maxNbChars = 200, $indexSize = 2)
        ];
    }
}
