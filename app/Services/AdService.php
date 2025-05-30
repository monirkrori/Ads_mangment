<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendAdConfirmationEmail;
use App\Jobs\SendAdReviewResultEmail;
use Illuminate\Database\Eloquent\Collection;

class AdService
{
    protected ImageService $imageService;

    /**
     * Inject dependencies
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Create a new ad and attach images
     *
     * @param array $data
     * @param User $user
     * @return Ad
     */
    public function create(array $data, User $user): Ad
    {
        return DB::transaction(function () use ($data, $user) {
            $ad = Ad::create([
                'title'       => $data['title'],
                'description' => $data['description'],
                'price'       => $data['price'],
                'status'      => 'pending',
                'user_id'     => $user->id,
                'category_id' => $data['category_id'],
            ]);

            // Use ImageService to handle attachments
            if (isset($data['images'])) {
                $this->imageService->attachImagesToModel($ad, $data['images']);
            }

            if ($ad->wasRecentlyCreated) {
                Log::info("New ad submitted: {$ad->title}");
            }

            SendAdConfirmationEmail::dispatch($user, $ad);

            return $ad;
        });
    }

    /**
     * Update an existing ad and its images
     *
     * @param Ad $ad
     * @param array $data
     * @return Ad
     */
    public function update(Ad $ad, array $data): Ad
    {
        $imageFiles = $data['images'] ?? [];
        unset($data['images']);

        $ad->fill($data);

        if ($ad->isDirty()) {
            $ad->save();
            Log::info("Ad updated (ID: {$ad->id})", $ad->getChanges());
        }

        if (!empty($imageFiles)) {
            $this->imageService->updateImages($ad, $imageFiles);
        }

        return $ad->fresh();
    }

    /**
     * Delete the given ad and its images.
     *
     * @param Ad $ad
     * @return void
     */
    public function delete(Ad $ad): void
    {
        $this->imageService->deleteImagesFromModel($ad);
        $ad->delete();
    }

    /**
     * Change ad status to 'active' or 'rejected'
     *
     * @param Ad $ad
     * @param string $status
     * @return Ad
     */
    public function reviewAd(Ad $ad, string $status): Ad
    {
        if (!in_array($status, ['active', 'rejected'])) {
            throw new \InvalidArgumentException("Invalid ad status: {$status}");
        }

        $ad->update(['status' => $status]);

        SendAdReviewResultEmail::dispatch($ad->user, $ad);

        return $ad;
    }


}
