<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'class'=>'common\components\lang\LangUrlManager',
            'rules'=>[
                '/' => 'site/index',

                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ]
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => [
                'user',
                'admin'
            ],

        ],

        'language'=>'ru-RU',
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceLanguage' => 'en',
                ],
                'blog' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceLanguage' => 'en',
                ],
            ],
        ],
    ],
];
