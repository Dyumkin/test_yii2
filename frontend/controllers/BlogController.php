<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use common\models\Blog;

class BlogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get']
                ],
            ],
        ];
    }
    /**
     * Blog list page.
     */
    function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Blog::find()->andWhere(['status_id' => Blog::STATUS_UNPUBLISHED]),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
    /**
     * Blog page.
     *
     * @param integer $id Blog ID
     * @param string $alias Blog alias
     *
     * @return mixed
     *
     * @throws \yii\web\NotFoundHttpException if blog was not found
     */
    public function actionView($id)
    {
        if (($model = Blog::findOne(['id' => $id])) !== null && !empty($model->content)) {
            $this->counter($model);
            return $this->render('view', [
                'model' => $model
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Update blog views counter.
     *
     * @param Blog $model Model
     */
    protected function counter($model)
    {
        $cookieName = 'blogs-views';
        $shouldCount = false;
        $views = Yii::$app->request->cookies->getValue($cookieName);
        if ($views !== null) {
            if (is_array($views)) {
                if (!in_array($model->id, $views)) {
                    $views[] = $model->id;
                    $shouldCount = true;
                }
            } else {
                $views = [$model->id];
                $shouldCount = true;
            }
        } else {
            $views = [$model->id];
            $shouldCount = true;
        }
        if ($shouldCount === true) {
            if ($model->updateViews()) {
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => $cookieName,
                    'value' => $views,
                    'expire' => time() + 86400 * 365
                ]));
            }
        }
    }

}
