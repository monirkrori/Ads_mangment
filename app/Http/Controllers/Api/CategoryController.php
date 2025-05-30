<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * list all categories
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->all();

        return $this->successResponse(CategoryResource::collection($categories), 'Categories retrieved successfully.');
    }

    /**
     * store a new category
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->create($request->validated());

        return $this->successResponse(new CategoryResource($category), 'Category created successfully.', 201);
    }

    /**
     * show a specific categoru with its ads count
     */
    public function show(Category $category): JsonResponse
    {
        $category->loadCount('ads');

        return $this->successResponse(new CategoryResource($category), 'Category retrieved successfully.');
    }

    /**
     * update a specific category
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {

        $updatedCategory = $this->categoryService->update($category, $request->validated());

        return $this->successResponse(new CategoryResource($updatedCategory), 'Category updated successfully.');
    }

    /**
     * delete a specific category
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->authorize('delete', $category);

        $this->categoryService->delete($category);

        return $this->successResponse(null, 'Category deleted successfully.');
    }
}
