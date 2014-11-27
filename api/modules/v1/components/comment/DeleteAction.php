<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 27.11.14
 * Time: 11:53
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\components\comment;

use Yii;
use yii\web\ServerErrorHttpException;
use yii\rest\DeleteAction as RestDelete;

class DeleteAction extends RestDelete{

    /**
     * Deletes a model.
     * @param mixed $id id of the model to be deleted.
     * @throws ServerErrorHttpException on failure.
     */
    public function run($id)
    {
        /* @var $model \api\modules\v1\models\Comment */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if ($model->deleteComment() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        Yii::$app->getResponse()->setStatusCode(204);

    }

}