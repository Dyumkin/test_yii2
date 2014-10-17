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
        ],

        'authManager' => [
            'class' => \Zelenin\yii\modules\Rbac\components\DbManager::className(),
            'itemFile' => '@common/config/rbac/items.php',
            'assignmentFile' => '@common/config/rbac/assignments.php',
            'ruleFile' => '@common/config/rbac/rules.php',
            'defaultRole' => 'user',
            'roleParam' => 'role', // User model attribute
            // optional
            'enableCaching' => false,
            'cachingDuration' => 60
        ]
    ],
];
