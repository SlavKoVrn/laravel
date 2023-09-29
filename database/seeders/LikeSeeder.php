<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\User;
use App\Models\Comment;

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
        $faker = Factory::create();

        $comments = Comment::all();

        foreach ($comments as $comment) {
            $users = User::inRandomOrder()->limit(10)->get();

            foreach ($users as $user) {
                Like::create([
                    'comment_id' => $comment->id,
                    'user_id' => $user->id,
                    'code' => $faker->randomDigit(),
                ]);
            }
        }
    }
}
