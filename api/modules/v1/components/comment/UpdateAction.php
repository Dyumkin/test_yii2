<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 27.11.14
 * Time: 11:45
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\components\comment;

use Yii;
use yii\base\Model;
use yii\web\ServerErrorHttpException;
use yii\rest\UpdateAction as RestUpdate;

class UpdateAction extends RestUpdate {

    /**
     * Updates an existing model.
     * @param string $id the primary key of the model.
     * @return \yii\db\ActiveRecordInterface the model being updated
     * @throws ServerErrorHttpException if there is any error when updating the model
     */
    public function run($id)
    {
        /* @var $model \api\modules\v1\models\Comment */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }

}