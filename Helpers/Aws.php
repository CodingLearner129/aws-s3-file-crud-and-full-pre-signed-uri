<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\Sdk;
use Exception;

/**
 * Aws s3 bucket - It is covered all aws s3 file operations  
 * private image full crud using s3 bucket
 * get the pre-signed URL of the image and upload the image using the pre-signed URL
 * 
 * @package  Aws
 * @author  Dhruv Parmar <dhruv.intelivita@gmail.com>
 */

class Aws
{
    /**
     * Upload any file to aws s3 bucket
     *
     * @param  string  $filePath (like: example/example)
     * @param  object  $setFile request File you want to store (like: $request->file, new File('/path'))
     * @param  string  $getFile (optional) File uri from database
     * @return string  uploaded file path
     */
    public static function uploadFileS3Bucket(string $filePath, object $setFile, string $getFile = ''): string
    {
        try {
            if ($getFile != '') {
                self::deleteFileS3Bucket($getFile);
            }
            $path = Storage::disk('s3')->put($filePath, $setFile, 'private');
            return Storage::disk('s3')->url($path);
        } catch (\Throwable $th) {
            throw new Exception($th);
        }
    }

    /**
     * delete any file from aws s3 bucket
     *
     * @param string $getFile
     */
    public static function deleteFileS3Bucket(string $getFile): void
    {
        try {
            $uploadedFile = str_replace(env('AWS_URL') . '/', '', $getFile);
            if ($uploadedFile != '') {
                if (Storage::disk('s3')->exists($uploadedFile)) {
                    Storage::disk('s3')->delete($uploadedFile);
                }
            }
        } catch (\Throwable $th) {
            throw new Exception($th);
        }
    }

    private function createS3SDK()
    {
        $region = env('AWS_DEFAULT_REGION');
        $keyId = env('AWS_ACCESS_KEY_ID');
        $secretKey = env('AWS_SECRET_ACCESS_KEY');
        $sdk = new Sdk([
            'region' => $region,
            'version' => 'latest',
            'credentials' => [
                'key'    => $keyId,
                'secret' => $secretKey,
            ],
        ]);
        return $sdk->createS3();
    }

    /**
     * Upload any file to aws s3 bucket to using presignedUri 
     *
     * @param  string  $filePath (like: example/example)
     * @param  string  $extension file extension you want to store,
     * @param  string  $fileName (optional) file name you want to store md5_file($fileName) or uniqid() or without encryption,
     * @param  string  $getFile (optional) File uri from database
     * @return array   fileUri file path to stored in database and presignedUri on which file being uploaded 
     */
    public static function presignedUriUpload(string $filePath, string $extension, string $fileName = '', string $getFile = ''): array
    {
        try {
            if ($getFile != '') {
                self::deleteFileS3Bucket($getFile);
            }
            $client = (new Aws())->createS3SDK();
            $bucket = env('AWS_BUCKET');
            $key = $filePath . '/' . str_replace(array('\'', '/', '?'), '', bcrypt($fileName)) . '.' . $extension;
            $options = [];
            $command = $client->getCommand('PutObject', [
                'Bucket' => $bucket,
                'Key' => $key,
                // 'ACL' => 'public-read'
                'ACL' => 'private'
            ], $options);

            $request = $client->createPresignedRequest($command, '+10 minutes');

            // return  (string) $request->getUri();
            return  ['fileUri' => env('AWS_URL') . '/' . $key, 'presignedUri' => (string) $request->getUri()];
        } catch (\Throwable $th) {
            throw new Exception($th);
        }
    }

    /**
     * get presigned uri of any file from aws s3 bucket
     *
     * @param  string $getFile
     * @return string ( presignedUri of file )
     */
    public static function presignedUri(string $getFile): string
    {
        try {
            $s3 = Storage::disk('s3');
            $uploadedFile = str_replace(env('AWS_URL') . '/', '', $getFile);
            if ($s3->exists($uploadedFile)) {
                $client = (new Aws())->createS3SDK();

                $bucket = env('AWS_BUCKET');
                $command = $client->getCommand('GetObject', [
                    'Bucket' => $bucket,
                    'Key' => $uploadedFile,
                ]);

                $request = $client->createPresignedRequest($command, '+10 minutes');

                return (string) $request->getUri();
            }

            return $getFile;
        } catch (\Throwable $th) {
            return asset('assets/img/400x300.jpg'); // default File
        }
    }
}
