<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 24.11.14
 * Time: 9:43
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\components\blog;

use Yii;
use api\modules\v1\components\helpers\ApiHelper;
use yii\base\Model;
use yii\web\ServerErrorHttpException;
use yii\rest\UpdateAction as RestUpdate;

class UpdateAction extends RestUpdate
{

    public function run($id)
    {
        /* @var $model \api\modules\v1\models\Blog */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->loadBlogLangs(Yii::$app->request->post('BlogLang'));
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        $data = ApiHelper::getRelationData($model, 'blogLangs');

        return $data;
    }

}