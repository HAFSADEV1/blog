<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //get tags count
        $tagsCount = Tag::count();
        Post::each(function ($post) use ($tagsCount) {
            $take = random_int(1, $tagsCount);
            $tagsIds = Tag::inRandomOrder()->take($take)->pluck('id');
            $post->tags()->sync($tagsIds);
        });
    }
}
