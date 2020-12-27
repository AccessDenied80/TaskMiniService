<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',
    'enableSchemaCache' => $_ENV['YII_ENV'] == 'prod' ? true : false,
    'schemaCache' => 'cache',
    'schemaCacheDuration' => 3600,
    /*'enableQueryCache' => $_ENV['YII_ENV'] == 'prod' ? true : false,
    'queryCacheDuration' => 60,
    'queryCache' => 'cache',*/
];
