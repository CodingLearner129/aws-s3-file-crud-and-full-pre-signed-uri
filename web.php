<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\Aws;

Route::get('test', function () {
    $filePath = 'images/test';
    $image = bcrypt(uniqid());
    $extension = 'png';
    // $imageUri = env('AWS_URL').'/'.$filePath.'/'.$image.'.'.$extension;
    $presignedUriUpload = Aws::presignedUriUpload($filePath, $image, $extension);

    // return ['image'=> $imageUri , 'presignedUrl' => $presignedUrl];
    return $presignedUriUpload;
});
