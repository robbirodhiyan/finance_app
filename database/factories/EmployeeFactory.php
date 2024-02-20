<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "nip" => $this->faker->randomNumber(9),
            "nik" => $this->faker->randomNumber(9),
            "name" => $this->faker->name(),
            "email" => $this->faker->unique()->safeEmail(),
            "whatsapp_number" => $this->faker->unique()->phoneNumber(),
            "address" => $this->faker->address(),
            "position_id" => $this->faker->numberBetween(1, 5),
            "no_bpjstk" => $this->faker->randomNumber(9),
            "no_npwp" => $this->faker->randomNumber(9),
            "bank_account" => $this->faker->randomNumber(9),
            "bank_code" => $this->faker->randomNumber(3),
            "employe_status_id" => $this->faker->numberBetween(1, 5),
            "salary" => $this->faker->numberBetween(1000000, 10000000),
        ];
    }
}
