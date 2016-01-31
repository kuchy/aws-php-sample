<?php
/*
 * Copyright 2013. Amazon Web Services, Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
**/

// Include the SDK using the Composer autoloader
require 'vendor/autoload.php';

/*
 If you instantiate a new client for Amazon Simple Storage Service (S3) with
 no parameters or configuration, the AWS SDK for PHP will look for access keys
 in the following order: environment variables, ~/.aws/credentials file, then finally
 IAM Roles for Amazon EC2 Instances. The first set of credentials the SDK is able
 to find will be used to instantiate the client.

 For more information about this interface to Amazon S3, see:
 http://docs.aws.amazon.com/aws-sdk-php/v3/guide/getting-started/basic-usage.html#creating-a-client
*/
$s3 = new Aws\S3\S3Client([
    'version' => '2006-03-01',
    'region'  => 'eu-central-1'
]);

/*
 Everything uploaded to Amazon S3 must belong to a bucket. These buckets are
 in the global namespace, and must have a unique name.

 For more information about bucket name restrictions, see:
 http://docs.aws.amazon.com/AmazonS3/latest/dev/BucketRestrictions.html
*/
$bucket = 'kuchy';
$filename  ='orange-pi-one-pocitac-raspberry-pi-nestandard2.jpg';
$imgUrl = 'http://ipravda.sk/res/2016/01/30/thumbs/'.$filename;
$img = file_get_contents($imgUrl);



/*
 Files in Amazon S3 are called "objects" and are stored in buckets. A specific
 object is referred to by its key (i.e., name) and holds data. Here, we create
 a new object with the key "hello_world.txt" and content "Hello World!".

 For a detailed list of putObject's parameters, see:
 http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html#putobject
*/

$response = $s3->doesObjectExist($bucket, $filename);

if ($response){
  echo 'Image already exist!' . "\r\n";
  echo 'url: https://s3.eu-central-1.amazonaws.com/kuchy/'.$filename . "\r\n";  
}
else{
  echo "Creating a new object with key {$filename}\n";
  $result =$s3->putObject([
      'Bucket' => $bucket,
      'Key'    => $filename,
      'Body'   => $img,
      'ContentType' => 'image/jpeg',
      'ACL'          => 'public-read',
  ]);

  echo 'url: '.$result['ObjectURL'] . "\r\n";  
}




