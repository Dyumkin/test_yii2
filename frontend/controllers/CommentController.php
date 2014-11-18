<?php

namespace frontend\controllers;

use Yii;
use common\models\Comments;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CommentController extends Controller
{
    /**
     * Create comment.
     */
    public function actionCreate()
    {
        $model = new Comments();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->tree($model);
                } else {
                    Yii::$app->response->setStatusCode(500);
                    return Yii::t('comments', 'FRONTEND_FLASH_FAIL_CREATE');
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->setStatusCode(400);
                return ActiveForm::validate($model);
            }
        }
    }
    /**
     * Update comment.
     *
     * @param integer $id Comment ID
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$model->setScenario('update');
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $model->content;
                } else {
                    Yii::$app->response->setStatusCode(500);
                    return Yii::t('comments', 'FRONTEND_FLASH_FAIL_UPDATE');
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->setStatusCode(400);
                return ActiveForm::validate($model);
            }
        }
    }
    /**
     * Delete comment page.
     *
     * @param integer $id Comment ID
     *
     * @return string Comment content
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($this->findModel($id)->deleteComment()) {
            return Yii::t('comments', 'FRONTEND_WIDGET_COMMENTS_DELETED_COMMENT_TEXT');
        } else {
            Yii::$app->response->setStatusCode(500);
            return Yii::t('comments', 'FRONTEND_FLASH_FAIL_DELETE');
        }
    }
    /**
     * Find model by ID.
     *
     * @param integer|array $id Comment ID
     *
     * @return Comments Model
     *
     * @throws HttpException 404 error if comment not found
     */
    protected function findModel($id)
    {
        /** @var Comments $model */
        $model = Comments::findOne($id);
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404, Yii::t('comments', 'FRONTEND_FLASH_RECORD_NOT_FOUND'));
        }
    }
    /**
     * @param Comments $model
     *
     * @return string Comments list
     */
    protected function tree($model)
    {
        $models = Comments::getTree($model->model_id, $model->model_class);
        return $this->renderPartial('@frontend/widgets/views/comment/_index_item', ['models' => $models]);
    }

}
