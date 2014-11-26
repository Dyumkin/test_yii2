<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 24.11.14
 * Time: 7:07
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\components\blog;

use Yii;
use api\modules\v1\components\helpers\ApiHelper;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\rest\CreateAction as RestCreate;

class CreateAction extends RestCreate
{

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /* @var $model \api\modules\v1\models\Blog */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->loadBlogLangs(Yii::$app->getRequest()->getBodyParam('BlogLang'));
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        $data = ApiHelper::getRelationData($model, 'blogLangs');

        return $data;
    }

}