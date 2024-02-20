<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeStatus>
 */
class EmployeStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
          "name" => $this->faker->randomElement(["Tetap", "Kontrak", "Magang"]),
          "start_date" => $start=$this->faker->dateTimeBetween("1 month", "+2 month"),
          "end_date" => $end=$this->faker->dateTimeBetween("3 month", "+10 month"),
          "duration" => $end->diff($start)->days,
        ];
    }
}
