<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'language' => 'ru-RU',
    'layout' => 'main.twig',
    'timeZone' => 'Europe/Kiev',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => $_ENV['COOKIE_VALIDATION_KEY'],
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'user' => [
            'identityClass' => \app\models\User::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'useFileTransport' => $_ENV['MAILER_TO_FILE'],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $_ENV['MAILER_HOST'],
                'username' => $_ENV['MAILER_USER'],
                'password' => $_ENV['MAILER_PASSWORD'],
                'port' => $_ENV['MAILER_PORT'],
                'encryption' => $_ENV['MAILER_ENCRYPTION'],
            ],
            'htmlLayout' => 'layouts/html.twig',
            'view' => [
                'defaultExtension' => 'twig',
                'class' => \yii\web\View::class,
                'renderers' => [
                    'twig' => [
                        'class' => \yii\twig\ViewRenderer::class,
                        'cachePath' => '@runtime/Twig/cache',
                        'options' => [
                            'auto_reload' => !YII_ENV_PROD,
                        ],
                        'functions' => [
                            't' => 'Yii::t',
                        ],
                    ],
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'view' => [
            /*'theme' => [
                'basePath' => '@frontend/v/desktop',
                'pathMap' => [
                    '@frontend/views' => '@frontend/v/desktop',
                    '@frontend/widgets' => '@frontend/v/desktop/widgets',
                ],
            ],*/
            'class' => \yii\web\View::class,
            'renderers' => [
                'twig' => [
                    'class' => \yii\twig\ViewRenderer::class,
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => !YII_ENV_PROD,
                    ],
                    'functions' => [
                        't' => 'Yii::t',
                    ],
                    'uses' => ['yii\bootstrap'],
                    'globals' => [
                        'Url' => ['class' => \yii\helpers\Url::class],
                    ],
                    'extensions' => [
                        \yii\twig\html\HtmlHelperExtension::class,
                    ],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
