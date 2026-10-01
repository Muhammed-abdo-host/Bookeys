<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['رواية', 'علمي', 'تاريخ', 'فلسفة', 'أدب', 'تقنية', 'سيرة ذاتية'];

        return [
            //

            'name' => fake()->unique()->randomElement($categories),

        ];
    }
}
