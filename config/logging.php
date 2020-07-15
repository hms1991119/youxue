<?php
return [
    'default' => env('LOG_CHANNEL','stack'),
    'channels' => [
        //自定义频道
        'myapplog' => [
            // 日志驱动模式：
            'driver' => 'daily',
            // 日志存放路径
            'path' => storage_path('logs/myapplog.log'),
            // 日志等级：
            'level' => 'info',
            // 日志分片周期，多少天一个文件
            'days' => 1,
        ],
        
        // 系统默认，可以合并几个频道，按等级对应记录，符合等级条件的都记录
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single','daily'],
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'info',
            'days' => 7,
        ],
    ]
];