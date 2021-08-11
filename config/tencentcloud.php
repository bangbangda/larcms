<?php

return [
    'secret_id' => env('TENCENT_CLOUD_SECRET_ID', ''),
    'secret_key' => env('TENCENT_CLOUD_SECRET_KEY', ''),

    'captcha' => [
        'app_id' => env('TENCENT_CLOUD_CAPTCHA_APP_ID', ''),
        'app_secret' => env('TENCENT_CLOUD_CAPTCHA_APP_SECRET', ''),
    ]
];