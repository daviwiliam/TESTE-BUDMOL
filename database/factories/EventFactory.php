<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->word,
            'description' => $this->faker->sentence,
            'start_date' => $this->faker->dateTimeThisMonth(),
            'end_date' => $this->faker->dateTimeThisMonth(),
            'location' => $this->faker->city,
            'capacity' => $this->faker->numberBetween(10, 100),
            'status' => $this->faker->randomElement(['open', 'closed', 'canceled']),
        ];
    }
}
