<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Debit>
 */
class DebitFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'name' => fake()->name(),
      'description' => fake()->sentence(),
      'total' => fake()->randomNumber(6),
      'date' => fake()->date(),
      // 'category_id' => Category::factory(),
      // 'source_id' => Source::factory()
    ];
  }
}
