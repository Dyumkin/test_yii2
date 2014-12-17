<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 09.12.14
 * Time: 6:57
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\Login;
use api\modules\v1\models\Signup;
use api\modules\v1\models\User;
use common\models\LoginForm;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;
use yii\helpers\Url;

class AuthController extends ActiveController{

    public $modelClass = 'api\modules\v1\models\User';

    protected function verbs()
    {
        return [
            'login' => ['POST'],
            'signup' => ['POST']
        ];
    }

    public function actionSignup()
    {
        $model = new Signup();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($user = $model->signup()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($user->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
            $user->setAccessToken();
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        } else {
            throw new \ErrorException('Validate Error', 401);
        }

        return $user->getData();
    }

    public function actionLogin()
    {
        if(Yii::$app->getRequest()->getBodyParam('access_token')){
            $model = new Login();
        } else {
            $model = new LoginForm();
        }
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return $model->getUser()->getData();
        } else {
            Yii::$app->getResponse()->setStatusCode(401);
            return $model->errors;
        }
    }
}