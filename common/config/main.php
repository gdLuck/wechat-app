<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => require(__DIR__ . '/db.php'),

        'cache' => [
            'class' => 'common\components\Cache',
            'keyPrefix'   => 'yii:wechat:datacache:',
            'redis' => [
                'hostname' => '',
                'password' => '',#本地配置会覆盖线上配置
                'port' => 6379,
                'database' => 0,
            ]
        ],
        'file_cache' => [
            'class' => 'yii\caching\FileCache',
            //'keyPrefix' => 'fileCache_wechat:',
            'directoryLevel' => 2,
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '',
            'password' => '',#本地配置会覆盖线上配置
            'port' => 6379,
            'database' => 0,
        ],
    ],
];
