<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalCopies=fake()->numberBetween(0,10);
        return [
            //
            'title'=>fake()->sentence(3),
            'total_copies'=>$totalCopies,
            'avilable_copies'=>fake()->numberBetween(0,$totalCopies),
            'author_id'=>Author::factory(),
            'category_id'=>Author::factory(),
        ];
    }
}
