<?php
namespace api\modules\v1;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init()
    {
        parent::init();

        \Yii::$app->user->enableSession = false;

        //need in Chrome
        \Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');
    }
}
