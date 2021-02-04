<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Table::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence(5),
            'num_seats' => $this->faker->numberBetween(4, 6),
            'hall_column' => $this->faker->numberBetween(0, 5),
            'hall_row' => $this->faker->numberBetween(0, 5),
        ];
    }
}
