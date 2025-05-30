<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendReviewNotificationEmail;
use Illuminate\Database\Eloquent\Collection;

class ReviewService
{
    /**
     * Create a review for an ad by a user.
     *
     * @param array $data
     * @param User $user
     * @return Review
     */
    public function create(array $data, User $user): Review
    {
        return DB::transaction(function () use ($data, $user) {
            $review = Review::create([
                'user_id' => $user->id,
                'ad_id'   => $data['ad_id'],
                'rating'  => $data['rating'],
                'comment' => $data['comment'],
            ]);

            if ($review->wasRecentlyCreated) {
                Log::info("Review created by User ID: {$user->id} for Ad ID: {$data['ad_id']}");

                SendReviewNotificationEmail::dispatch($review->ad->user, $review->ad);

            }

            return $review;
        });
    }

    /**
     * Update an existing review.
     *
     * @param Review $review
     * @param array $data
     * @return Review
     */
    public function update(Review $review, array $data): Review
    {
        $review->fill($data);

        if ($review->isDirty()) {
            $review->save();
            Log::info("Review updated ID: {$review->id}", $review->getChanges());
        }

        return $review->fresh();
    }

    /**
     * Delete a review.
     *
     * @param Review $review
     * @return void
     */
    public function delete(Review $review): void
    {
        $review->delete();
        Log::info("Review deleted ID: {$review->id}");
    }

    /**
     * Get all reviews for a given ad.
     *
     * @param Ad $ad
     * @return Collection
     */
    public function getReviewsForAd(Ad $ad): Collection
    {
        return $ad->reviews()->with('user')->latest()->get();
    }
}
