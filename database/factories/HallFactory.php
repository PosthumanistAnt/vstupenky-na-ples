<?php

namespace Database\Factories;

use App\Models\Hall;
use Illuminate\Database\Eloquent\Factories\Factory;

class HallFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hall::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'location' => $this->faker->cityPrefix(),
            'table_columns' => $this->faker->numberBetween(10, 30),
            'table_rows' => $this->faker->numberBetween(10, 30),
            'description' => $this->faker->sentence(5),
        ];
    }
}
