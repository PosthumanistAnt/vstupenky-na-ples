<?php

namespace Database\Factories;

use App\Models\SeatType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeatTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SeatType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' =>  $this->faker->word(),
            'description' => $this->faker->sentence(5),
            'price' => $this->faker->randomNumber(3, true),
        ];
    }
}
