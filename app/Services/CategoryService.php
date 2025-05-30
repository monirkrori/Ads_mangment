<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        return DB::transaction(function () use ($data) {
            $category = Category::create([
                'name' => $data['name'],
                'slug' => $data['slug']
            ]);

            if ($category->wasRecentlyCreated) {
                Log::info("Category created: {$category->name}");
            }

            return $category;
        });
    }

    /**
     * Update existing category.
     *
     * @param Category $category
     * @param array $data
     * @return Category
     */
    public function update(Category $category, array $data): Category
    {
        $category->fill($data);

        if ($category->isDirty()) {
            $category->save();
            Log::info("Category updated: ", $category->getChanges());
        }

        return $category->fresh();
    }

    /**
     * Delete a category.
     *
     * @param Category $category
     * @return void
     */
    public function delete(Category $category): void
    {
        $category->delete();
        Log::info("Category deleted: {$category->name}");
    }

    /**
     * Get all categories.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Category::all();
    }
}
