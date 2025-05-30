<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $categories = Category::all();

        foreach ($users as $user) {
            foreach ($categories as $category) {
                $user->ads()->create([
                    'title'       => 'Sample Ad for ' . $category->name,
                    'description' => 'This is a sample description for ' . $category->name,
                    'price'       => rand(50, 1000),
                    'category_id' => $category->id,
                    'status'      => 'active',
                ]);
            }
        }
    }
}
