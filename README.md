# aws-s3-file-crud-and-full-pre-signed-uri

How to use this component???

1. Run below command to install dependencies of aws-s3 for laravel
    ```bash
    composer require league/flysystem-aws-s3-v3
    ```

2. Copy "Helpers" directory of this component in your project "app" directory. If you already have a "Helpers" directory in your project's "app" directory then copy Aws.php in your project's "Helpers" directory

3. Add 'Aws' alias by add 'Aws' => App\Helpers\Aws::class in alias section of app.php of config file of your project

4. Update environment variables in your .env file like this component's .env file

5. Now you can use this component's function ex. Aws::uploadFileS3Bucket('file/example', $request->file)

# There is a postman file for the demo of upload file to perSignedURL

# Canned ACL
Amazon S3 supports a set of predefined grants, known as canned ACLs. Each canned ACL has a predefined set of grantees and permissions. The following table lists the set of canned ACLs and the associated predefined grants.

# Canned ACL	Applies to	Permissions added to ACL
private:	| Bucket and object |	Owner gets FULL_CONTROL. No one else has access rights (default).
public-read:	| Bucket and object |	Owner gets FULL_CONTROL. The AllUsers group (see Who is a grantee?) gets READ access.
public-read-write:	| Bucket and object |	Owner gets FULL_CONTROL. The AllUsers group gets READ and WRITE access. Granting this on a bucket is generally not recommended.
aws-exec-read:	| Bucket and object |	Owner gets FULL_CONTROL. Amazon EC2 gets READ access to GET an Amazon Machine Image (AMI) bundle from Amazon S3.
authenticated-read: | Bucket and object |	Owner gets FULL_CONTROL. The AuthenticatedUsers group gets READ access.
bucket-owner-read: | Object |	Object owner gets FULL_CONTROL. Bucket owner gets READ access. If you specify this canned ACL when creating a bucket, Amazon S3 ignores it.
bucket-owner-full-control: | Object |	Both the object owner and the bucket owner get FULL_CONTROL over the object. If you specify this canned ACL when creating a bucket, Amazon S3 ignores it.
log-delivery-write:	| Bucket |	The LogDelivery group gets WRITE and READ_ACP permissions on the bucket. For more information about logs, see (Logging requests using server access logging).
Note
You can specify only one of these canned ACLs in your request.

You specify a canned ACL in your request by using the x-amz-acl request header. When Amazon S3 receives a request with a canned ACL in the request, it adds the predefined grants to the ACL of the resource.

You can refer this from https://docs.aws.amazon.com/AmazonS3/latest/userguide/acl-overview.html#sample-acl

So now, setup of this component is done.
Best of luck guys,
Thank you