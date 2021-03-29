<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reservation_start' => $this->faker->dateTimeBetween('now', '+1 week'),
            'reservation_end' => $this->faker->dateTimeBetween('+2 week', '+3 week'),
            'ball_start' => $this->faker->dateTimeBetween('+2 week', '+3 week'),
            'location' => $this->faker->streetAdress(),
            'description' => $this->faker->sentence(3),
        ];
    }
}
