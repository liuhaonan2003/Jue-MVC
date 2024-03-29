<?php
require_once dirname(__DIR__).'/aliyun.php';

use Aliyun\OSS\OSSClient;

// Sample of multipart upload
function multipartUploadSample() {
    $fileName = __Package__.'oss/samples/test.dmg';
    $bucket = 'xiaocao';
    $key = 'python';

    $partSize = 5 * 1024 * 1024; // 5M for each part

    $client = OSSClient::factory(array(
        'AccessKeyId' => 'FRwMcN14jP4dZ321',
        'AccessKeySecret' => 'WgekRpIGUePJvpWXIveRSIqjxrZG7Q',
    ));

    // Init multipart upload
    $uploadId = $client->initiateMultipartUpload(array(
        'Bucket' => $bucket,
        'Key' => $key,
    ))->getUploadId();

    // upload parts
    $fileSize = filesize($fileName);
    $partCount = (int) ($fileSize / $partSize);
    if ($fileSize % $partSize > 0) {
        $partCount += 1;
    }

    $partETags = array();
    for ($i = 0; $i < $partCount ; $i++) {
        $uploadPartSize = ($i + 1) * $partSize > $fileSize ? $fileSize - $i * $partSize : $partSize;
        $file = fopen($fileName, 'r');
        fseek($file, $i * $partSize);
        $partETag = $client->uploadPart(array(
            'Bucket' => $bucket,
            'Key' => $key,
            'UploadId' => $uploadId,
            'PartNumber' => $i + 1,
            'PartSize' => $uploadPartSize,
            'Content' => $file,
        ))->getPartETag();
        $partETags[] = $partETag;
    }

    $result =  $client->completeMultipartUpload(array(
        'Bucket' => $bucket,
        'Key' => $key,
        'UploadId' => $uploadId,
        'PartETags' => $partETags,
    ));

    echo "Completed: " . $result->getETag();
}

multipartUploadSample();

?>