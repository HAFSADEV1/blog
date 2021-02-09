<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect(['Travel', 'Science', 'Games', 'Cars', 'Books', 'News', 'Basketball']);
        $tags->each(function ($tag) {
            $mytag = new Tag();
            $mytag->name = $tag;
            $mytag->save();
        });
    }
}
