<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use InterventionImage;

// filename renamed
class ImageService
{
    public static function upload($imageFile, $folderName) {
        if(is_array($imageFile)) {
            $file = $imageFile['image'];
        } else {
            $file = $imageFile;
        }

        $fileName = uniqid(rand().'_'); 
        $extension = $file->extension();
        $fileNameToStore = $fileName . '.' . $extension;
        $resizedImage = InterventionImage::make($file)->resize(1024, 1024)->encode(); 
        
        Storage::put('public/'. $folderName . '/' . $fileNameToStore, $resizedImage);
    
        return $fileNameToStore;
    }
}

?>