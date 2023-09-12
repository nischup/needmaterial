<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function saveImage($image, $name = null, $width = 500, $height = 500) {
        if (!$name) {
            $name = Str::random() . '.jpg';
        }

        $img = Image::make($image)->orientate()->resize($width, $height,
            function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })
            ->resizeCanvas($width, $height)
            ->encode('jpg');

        Storage::disk('public')->put($name, $img);

        return $name;
    }
}