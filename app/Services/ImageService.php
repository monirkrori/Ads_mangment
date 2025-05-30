<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class ImageService
{
    /**
     * Attach multiple images to a model 
     *
     * @param Model $model
     * @param array $images
     * @return void
     */
    public function attachImagesToModel(Model $model, array $images): void
    {
        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $path = $image->store('images', 'public');
                $model->images()->create(['path' => $path]);
            }
        }
    }

    /**
     * Delete all associated images from a model and storage
     *
     * @param Model $model
     * @return void
     */
    public function deleteImagesFromModel(Model $model): void
    {
        foreach ($model->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
    }

    /**
     * Replace old images with new ones
     *
     * @param Model $model
     * @param array $newImages
     * @return void
     */
    public function updateImages(Model $model, array $newImages): void
    {
        $this->deleteImagesFromModel($model);
        $this->attachImagesToModel($model, $newImages);
    }
}
