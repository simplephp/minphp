<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'commands',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'min\console\Input',
        ],
        'db' => $db,
    ],
    'params' => $params,
];

return $config;
