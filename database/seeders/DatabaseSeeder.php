<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Post;
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
    if ($this->command->confirm("do you want to refresh the database ?")) {
      $this->command->call("migrate:refresh");
      $this->command->info("database was refreshed");
    }
    $this->call([
      UsersTableSeeder::class,
      PostsTableSeeder::class,
      CommentSeeder::class,
      TagTableSeeder::class,
      PostTagSeeder::class
    ]);
  }
}
