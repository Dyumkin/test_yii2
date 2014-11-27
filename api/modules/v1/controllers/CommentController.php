<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 26.11.14
 * Time: 7:58
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;

class CommentController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Comment';

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
            'view' => [
                'class' => 'api\modules\v1\components\comment\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'create' => [
                'class' => 'api\modules\v1\components\comment\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'update' => [
                'class' => 'api\modules\v1\components\comment\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'delete' => [
                'class' => 'api\modules\v1\components\comment\DeleteAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

}