<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function uploadImages(array $images, string $directory, $model, string $relationship = 'images'): void
    {
        foreach ($images as $index => $image) {
            if ($image instanceof UploadedFile) {
                $path = $image->store($directory, 'public');
                $model->{$relationship}()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0 && $model->{$relationship}()->count() === 0,
                    'sort_order' => $model->{$relationship}()->count(),
                ]);
            }
        }
    }

    public function deleteImage(string $path): void
    {
        Storage::disk('public')->delete($path);
    }

    public function deleteAllImages($model, string $relationship = 'images'): void
    {
        foreach ($model->{$relationship} as $image) {
            $this->deleteImage($image->image_path);
            $image->delete();
        }
    }
}
