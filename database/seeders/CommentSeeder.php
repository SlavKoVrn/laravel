<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\DatabaseManager as DB;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $database = app()->get(DB::class);
        $database->table('comments')->truncate();

        Comment::factory()
            ->count(100)
            ->create();
    }
}
