<?php

namespace App\Helpers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function resizeImage($path)
    {
        if (Storage::exists($path)) {
            $image = Image::make(Storage::path($path));
            $image->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $compressedPath = 'compressed/' . basename($path);
            Storage::put($compressedPath, (string) $image->encode('jpg', 70)); // Kompres ke 70%

            return $compressedPath;
        }

        return $path;
    }
}
