<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\User;
use App\Models\Comment;

use Illuminate\Database\DatabaseManager as DB;
use Illuminate\Database\Seeder;
use Faker\Factory;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $database = app()->get(DB::class);
        $database->table('likes')->truncate();

        $faker = Factory::create();

        $comments = Comment::all();
        $users = User::all();

        foreach ($comments as $comment) {
            foreach ($users as $user) {
                Like::create([
                    'comment_id' => $comment->id,
                    'user_id' => $user->id,
                    'code' => $faker->randomDigit(),
                ]);
                echo "$comment->id - $user->id\n";
            }
        }
    }
}
