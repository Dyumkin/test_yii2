<?php

namespace backend\controllers;

use Yii;
use backend\models\CommentsModel;
use backend\models\search\CommentsModelSearch;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CommentModelController extends \yii\web\Controller
{
    /**
     * Comment models list page.
     */
    public function actionIndex()
    {
        $searchModel = new CommentsModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $statusArray = CommentsModel::getStatusArray();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'statusArray' => $statusArray
        ]);
    }
    /**
     * Create model page.
     */
    public function actionCreate()
    {
        $model = new CommentsModel();
        $statusArray = CommentsModel::getStatusArray();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->redirect(['update', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('danger', Yii::t('comments-models', 'BACKEND_FLASH_FAIL_ADMIN_CREATE'));
                    return $this->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusArray' => $statusArray
        ]);
    }
    /**
     * Update model page.
     *
     * @param integer $id Post ID
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$model->setScenario('admin-update');
        $statusArray = CommentsModel::getStatusArray();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('danger', Yii::t('comments-models', 'BACKEND_FLASH_FAIL_ADMIN_UPDATE'));
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
     * Delete model page.
     *
     * @param integer $id Post ID
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    /**
     * Delete multiple models page.
     *
     * @return mixed
     * @throws \yii\web\HttpException
     */
    public function actionBatchDelete()
    {
        if (($ids = Yii::$app->request->post('ids')) !== null) {
            $models = $this->findModel($ids);
            foreach ($models as $model) {
                $model->delete();
            }
            return $this->redirect(['index']);
        } else {
            throw new HttpException(400);
        }
    }
    /**
     * Enable comments for indicated extension
     *
     * @param string $name Extension name
     *
     * @return mixed
     */
/*    public function actionEnable($name)
    {
        if (!CommentsModels::enableExtension($name)) {
            Yii::$app->session->setFlash('danger', Yii::t('comments-models', 'BACKEND_FLASH_FAIL_ADMIN_ENABLE'));
        }
        return $this->redirect(['index']);
    }*/
    /**
     * Disable comments for indicated extension
     *
     * @param string $name Extension name
     *
     * @return mixed
     */
/*    public function actionDisable($name)
    {
        if (!CommentsModels::disableExtension($name)) {
            Yii::$app->session->setFlash('danger', Yii::t('comments-models', 'BACKEND_FLASH_FAIL_ADMIN_DISABLE'));
        }
        return $this->redirect(['index']);
    }*/
    /**
     * Find model by ID.
     *
     * @param integer|array $id Model ID
     *
     * @return CommentsModel
     *
     * @throws HttpException 404 error if model not found
     */
    protected function findModel($id)
    {
        if (is_array($id)) {
            $model = CommentsModel::findAll($id);
        } else {
            $model = CommentsModel::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }
}

