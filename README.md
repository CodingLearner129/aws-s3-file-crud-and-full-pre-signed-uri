# aws-s3-file-crud-and-full-pre-signed-uri

How to use this component???

1. Run below command to install dependencies of aws-s3 for laravel
    composer require league/flysystem-aws-s3-v3

2. Copy "Helpers" directory of this component in your project "app" directory. If you already have a "Helpers" directory in your project's "app" directory then copy Aws.php in your project's "Helpers" directory

3. Add 'Aws' alias by add 'Aws' => App\Helpers\Aws::class in alias section of app.php of config file of your project

4. Update environment variables in your .env file like this component's .env file

5. Now you can use this component's function ex. Aws::uploadFileS3Bucket('file/example', $request->file)

There is a postman file for the demo of upload file to perSignedURL

So now, setup of this component is done.
Best of luck guys,
Thank you
