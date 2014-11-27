<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 27.11.14
 * Time: 9:38
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\components\comment;

use Yii;
use api\modules\v1\components\helpers\ApiHelper;
use api\modules\v1\models\Comment;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\rest\CreateAction as RestCreate;

class CreateAction extends RestCreate {

    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws ServerErrorHttpException if there is any error when creating the model
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /* @var $model \api\modules\v1\models\Comment */
        $model = new $this->modelClass();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $this->tree($model);
    }

    /**
     * @param \api\modules\v1\models\Comment $model
     *
     * @return string Comments list
     */
    protected function tree($model)
    {
        $models = Comment::getTree($model->model_id, $model->model_class);
        return $models;
    }

}