<?php

namespace backend\controllers;

use Yii;
use backend\models\CommentsModel;
use backend\models\search\CommentsSearch;
use common\models\Comments;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CommentController extends \yii\web\Controller
{

    /**
     * Comments list page.
     */
    public function actionIndex()
    {
        $searchModel = new CommentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $statusArray = Comments::getStatusArray();
        $modelArray = CommentsModel::getModelArray();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'statusArray' => $statusArray,
            'modelArray' => $modelArray
        ]);
    }
    /**
     * Update comment page.
     *
     * @param integer $id Comment ID
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$model->setScenario('admin-update');
        $statusArray = Comments::getStatusArray();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('danger', Yii::t('comments', 'BACKEND_FLASH_FAIL_ADMIN_UPDATE'));
                    return $this->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'statusArray' => $statusArray
        ]);
    }
    /**
     * Delete comment page.
     *
     * @param integer $id Comment ID
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteComment();
        return $this->redirect(['index']);
    }
    /**
     * Delete multiple comments page.
     *
     * @return mixed
     * @throws \yii\web\HttpException
     */
    public function actionBatchDelete()
    {
        if (($ids = Yii::$app->request->post('ids')) !== null) {
            $models = $this->findModel($ids);
            foreach ($models as $model) {
                $model->deleteComment();
            }
            return $this->redirect(['index']);
        } else {
            throw new HttpException(400);
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
        if (is_array($id)) {
            $model = Comments::findAll($id);
        } else {
            $model = Comments::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }

}
