<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create()->each(function ($user) {
            $user->posts()->saveMany(\App\Models\Post::factory(rand(2,10))->make());
        });
        // \App\Models\User::factory(20)->create();
        // \App\Models\Post::factory(20)->create();
        \App\Models\Country::factory()->create(['name'=>'Egypt']);
        \App\Models\Country::factory()->create(['name'=>'KSa']);
        \App\Models\Country::factory()->create(['name'=>'UAE']);
        \App\Models\Country::factory()->create(['name'=>'Jordan']);
    }
}
