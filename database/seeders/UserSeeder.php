<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\DatabaseManager as DB;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Seeder;
use Faker\Factory;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        $database = app()->get(DB::class);
        $database->table('users')->truncate();

        $faker = Factory::create();

        $userRepository = app()->get(UserRepositoryInterface::class);
        $userRepository->create([
            'name' => 'John Doe',
            'email' => 'john_doe@gmail.com',
            'password' => '123456'
        ]);

        for ($i=1;$i<=100;$i++){
            $userRepository->create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $faker->word()
            ]);
        }
    }
}
