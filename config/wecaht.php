<?php

return [
    'mini_app' => [
        'app_id' => env('WECHAT_MINI_APP_ID'),
        'secret' => env('WECHAT_MINI_SECRET'),

        // 下面为可选项
        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',
        'log' => [
            'level' => 'debug',
            'file' => __DIR__.'/wechat.log',
        ],
    ],
    'pay' => [
        'app_id' => env('WECHAT_MP_APP_ID'),
        'mch_id' => env('WECHAT_PAY_MACH_ID'),
        'key' => env('WECHAT_PAY_API_KEY'),   // API 密钥
        'cert_path' => env('WECHAT_PAY_CERT_PATH'), // XXX: 绝对路径！！！！
        'key_path' => env('WECHAT_PAY_KEY_PATH'),      // XXX: 绝对路径！！！！
    ],
    'mp' => [
        'app_id' => env('WECHAT_MP_APP_ID'),
        'secret' => env('WECHAT_MP_SECRET'),
        'response_type' => 'array',
    ]
];