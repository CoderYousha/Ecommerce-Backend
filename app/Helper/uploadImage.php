<?php

if (!function_exists('uploadImage')) {
    function uploadImage($image, $path)
    {
        $imagePath = $image->storePublicly($path, 'public');
        
        return 'storage/' . $imagePath;
    }
}