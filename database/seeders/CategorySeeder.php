<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Electronics', 'Furniture', 'Vehicles', 'Real Estate', 'Jobs'];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);

        }
    }
}
