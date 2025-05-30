<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Services\AdService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\AdResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ad\StoreAdRequest;
use App\Http\Requests\Ad\UpdateAdRequest;

class AdController extends Controller
{
    protected AdService $adService;

    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    /**
     * List all active ads with main image and review count
     */
    public function index(): JsonResponse
    {
        $ads = Ad::active()
            ->with(['user', 'category'])
            ->withReviewCount()
            ->withMainImage()
            ->latest()
            ->get();

        return $this->successResponse(AdResource::collection($ads), 'Active ads retrieved successfully.');
    }

    /**
     * Store a new ad
     */
    public function store(StoreAdRequest $request): JsonResponse
    {
        $ad = $this->adService->create($request->validated(), $request->user());

        return $this->successResponse(new AdResource($ad->load('images')), 'Ad created successfully', 201);
    }

    /**
     * Show a specific ad
     */
    public function show(Ad $ad): JsonResponse
    {
        $ad->load(['user', 'category', 'images'])->loadCount('reviews');

        return $this->successResponse(new AdResource($ad), 'Ad retrieved successfully');
    }

    /**
     * Update the ad
     */
    public function update(UpdateAdRequest $request, Ad $ad): JsonResponse
    {

        $updatedAd = $this->adService->update($ad, $request->validated());

        return $this->successResponse(new AdResource($updatedAd->load('images')), 'Ad updated successfully.');
    }

    /**
     * Delete the ad and its images
     */
    public function destroy(Ad $ad): JsonResponse
    {
        $this->authorize('delete', $ad);

        $this->adService->delete($ad);

        return $this->successResponse(null, 'Ad deleted successfully');
    }

    /**
     * Review an ad (approve or reject)
     */
    public function review(Ad $ad, string $status): JsonResponse
    {
        $this->authorize('approve', $ad);

        $reviewedAd = $this->adService->reviewAd($ad, $status);

        return $this->successResponse(new AdResource($reviewedAd), 'Ad status updated to ' . $status);
    }

    /**
     * Get all ads for a specific user
     */
    public function userAds(int $userId): JsonResponse
    {
        $ads = Ad::userAds($userId)
            ->with('category')
            ->withReviewCount()
            ->withMainImage()
            ->latest()
            ->get();

        return $this->successResponse(AdResource::collection($ads), 'User ads retrieved successfully.');
    }
}
