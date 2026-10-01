<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Client',
            'email' => 'client@library.com',
            'password' => bcrypt('password'),
            'role' => 'client',
        ]);

        $authors    = Author::factory(8)->create();
        $categories = Category::factory(6)->create();

        Book::factory(30)->create([
            'author_id'   => fn() => $authors->random()->id,
            'category_id' => fn() => $categories->random()->id,
        ]);
    }
}
