<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//
//        $this->call(PermissionSeeder::class);
//        \App\Models\User::factory(10)->create();
//        \App\Models\Post::factory(20)->create();
//        \App\Models\Product::factory(20)->create();
        \App\Models\Productreview::factory(20)->create();
    }
}
