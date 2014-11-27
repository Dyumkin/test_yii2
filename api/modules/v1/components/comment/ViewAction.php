<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 21.11.14
 * Time: 11:32
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\components\comment;

use api\modules\v1\models\Comment;
use api\modules\v1\models\Blog;
use common\components\helpers\CommonHelper;
use yii\web\NotFoundHttpException;
use yii\rest\ViewAction as RestView;

class ViewAction extends RestView
{
    /**
     * @var \api\modules\v1\models\Blog|null model
     */
    protected $model;

    /**
     * @param \api\modules\v1\models\Blog $id
     * @return array|\yii\db\ActiveRecordInterface
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        $this->model = Blog::findOne($id);

        if ($this->model != null) {

            $class = $this->model->getParentClassName();
            $models = Comment::getTree($this->model->id, CommonHelper::generateCRC32Hash($class));
            $model = new Comment();
            $model->model_class = $class;
            $model->model_id = $this->model->id;

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $model);
            }

            $data = [
                'model' => $model,
                'models' => $models
            ];

            return $data;

        } else {
            throw new NotFoundHttpException("Object not found: $id");
        }
    }
}