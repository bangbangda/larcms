<?php

return [
    'mini_app' => [
        'app_id' => env('WECHAT_MINI_APP_ID'),
        'secret' => env('WECHAT_MINI_SECRET'),

        // 下面为可选项
        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',
        'log' => [
            'default' => env('WECHAT_MINI_LOG_CHANNEL', 'dev'), // 默认使用的 channel，生产环境可以改为下面的 prod
            'channels' => [
                // 测试环境
                'dev' => [
                    'driver' => 'single',
                    'path' => '/tmp/easywechat.log',
                    'level' => 'debug',
                ],
                // 生产环境
                'prod' => [
                    'driver' => 'daily',
                    'path' => '/tmp/easywechat.log',
                    'level' => 'info',
                ],
            ],
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
        'token' => env('WECHAT_MP_TOKEN'),
        'response_type' => 'array',
    ]
];