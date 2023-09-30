<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;

class CommentFactory extends Factory
{
    protected $faker;

    function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);
        $this->faker = FakerFactory::create('ru_RU');
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => random_int(1,100),
            'title' => $this->faker->realText(22),
            'content' => $this->faker->realText(1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
