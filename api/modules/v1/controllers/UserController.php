<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 28.11.14
 * Time: 5:45
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\Signup;
use api\modules\v1\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Url;

class UserController extends ActiveController {

    public $modelClass = 'api\modules\v1\models\User';

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
                ],

                'verbFilter' => [
                    'class' => VerbFilter::className(),
                    'actions' => $this->verbs(),
                ],
            ]
        );
    }

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'signup' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['status' => User::STATUS_ACTIVE]),
            'pagination' => [
                'pageSize' => Yii::$app->params['api.user.pageSize']
            ]
        ]);

        $models = $dataProvider->getModels();

        $data = [];
        foreach ($models as $model)
        {
            /** @var $model User */
            $data[] = $model->getData();
        }

        return $data;
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

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $model->getData();
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model->getData();
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->deleteUser() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        Yii::$app->getResponse()->setStatusCode(204);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested User does not exist.');
        }
    }

}