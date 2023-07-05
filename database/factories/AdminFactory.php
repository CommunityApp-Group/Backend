<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->Name,
            'location' => $this->faker->city(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail,
            'created_by' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

        ];

    }
    public function configure()
    {
        return $this->afterCreating(function (Admin $admin) {
            $permissions = Permission::pluck('id','id')->all();

        });
    }
}