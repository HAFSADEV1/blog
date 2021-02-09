<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $users=User::all();
        Post::factory()->count(5)->make()->each(function($post) use ($users){
            $post->user_id=$users->random()->id;
            $post->save();
            });

    }
}
