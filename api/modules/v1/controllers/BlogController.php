<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 19.11.14
 * Time: 4:50
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\controllers;

use api\modules\v1\models\Blog;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;

class BlogController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Blog';

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),[
                'authenticator' => [
                    'class' => CompositeAuth::className(),

                    'authMethods' => [
                        HttpBasicAuth::className(),
                        HttpBearerAuth::className(),
                        QueryParamAuth::className(),
                    ]
                ]
            ]
        );
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => 'api\modules\v1\components\blog\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'view' => [
                'class' => 'api\modules\v1\components\blog\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'create' => [
                'class' => 'api\modules\v1\components\blog\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => Blog::SCENARIO_INSERT,
            ],
            'update' => [
                'class' => 'api\modules\v1\components\blog\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => Blog::SCENARIO_UPDATE,
            ],
            'delete' => [
                'class' => 'yii\rest\DeleteAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

}