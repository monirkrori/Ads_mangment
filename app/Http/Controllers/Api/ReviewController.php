<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;

class ReviewController extends Controller
{
    protected ReviewService $reviewService;

    /**
     * depenencies injection
     */
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * list all reviews
     */
    public function index(): JsonResponse
    {
        $reviews = Review::with(['user', 'ad'])->latest()->get();

        return $this->successResponse(ReviewResource::collection($reviews), 'Reviews retrieved successfully.');
    }

    /**
     * make a new review
     */
    public function store(StoreReviewRequest $request): JsonResponse
    {
        $review = $this->reviewService->create($request->validated(), $request->user());

        return $this->successResponse(new ReviewResource($review), 'Review created successfully.', 201);
    }

    /**
     * show a specific review
     */
    public function show(Review $review): JsonResponse
    {
        $review->load(['user', 'ad']);

        return $this->successResponse(new ReviewResource($review), 'Review retrieved successfully.');
    }

    /**
     * update a specific review
     */
    public function update(UpdateReviewRequest $request, Review $review): JsonResponse
    {
        $updatedReview = $this->reviewService->update($review, $request->validated());

        return $this->successResponse(new ReviewResource($updatedReview), 'Review updated successfully.');
    }

    /**
     * destroy a specific review
     */
    public function destroy(Review $review): JsonResponse
    {
        $this->authorize('delete', $review);

        $this->reviewService->delete($review);

        return $this->successResponse(null, 'Review deleted successfully.');
    }
}
