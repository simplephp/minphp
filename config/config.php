<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [

    'components' => [
        'cache' => [
            'class' => 'min\console\Input',
        ],
        'db' => $db,
    ],
    //'params' => $params,
];

return $config;
