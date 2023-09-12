<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentUploadService
{
    public function saveFile($file) {
        if (!$file) {
            return null;
        }

        if ($file) {
            $name = Str::random() .'.'. $file->getClientOriginalExtension();
        }

        Storage::disk('public')->putFileAs('/profile/', $file, $name);

        return $name;
    }


}
