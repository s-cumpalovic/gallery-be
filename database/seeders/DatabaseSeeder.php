<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::factory(15)->create()->each(function ($user) {
            \App\Models\Gallery::factory(3)->create(['user_id' => $user->id])->each(function ($gallery) {
                \App\Models\Image::factory(7)->create(['gallery_id' => $gallery->id]);
                \App\Models\Comment::factory(2)->create(['gallery_id' => $gallery->id, 'user_id' => $gallery->user_id]);
            });
        });


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
