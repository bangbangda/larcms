<?php
return [
    'accessKeyId' => env('OSS_ACCESS_KEY_ID', ''),
    'accessKeySecret' => env('OSS_ACCESS_KEY_SECRET', ''),
    'endpoint' => env('OSS_ENDPOINT', ''),
    'defaultBucket' => env('OSS_DEFAULT_BUCKET', ''),
    'httpTimeout' => env('OSS_HTTP_TIMEOUT', 10),
];