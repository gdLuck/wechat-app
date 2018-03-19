<?php
require(__DIR__ . '/../../common/config/constant-prod.php');

// 定义使用情况 0正常 1初次验证
define('FIRST_TIME', 1);

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-prod.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-prod.php')
);

(new yii\web\Application($config))->run();
