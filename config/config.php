<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    // 命令命名空间
    'commandNamespace' => 'app\commands',

    // 命令
    'commands'         => [

        'push start'   => ['Push', 'Start'],
        'push stop'    => ['Push', 'Stop'],
        'push restart' => ['Push', 'Restart'],
        'push status'  => ['Push', 'Status'],

    ],
    'components' => [
        'cache' => [
            'class' => 'min\console\Input',
        ],
        'db' => $db,
    ],
    //'params' => $params,
];

return $config;
