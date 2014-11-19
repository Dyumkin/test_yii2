<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 19.11.14
 * Time: 4:50
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\controllers;

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

}