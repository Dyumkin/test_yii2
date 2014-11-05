<?php

namespace backend\controllers;

use Yii;
use common\models\Blog;
use common\models\BlogLang;
use common\models\Lang;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\components\helpers\BlogHelper;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Blog::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blog();

        $posts = [];
        foreach (ArrayHelper::map(Lang::find()->asArray()->all(), 'id', 'url') as $langName)
        {
            $post  = new BlogLang();
            $posts[$langName] = $post;
        }

        $model->setScenario(Blog::SCENARIO_INSERT);

        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request->post();
           $model->loadBlogLangs($request['BlogLang']);

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
               throw new HttpException(500, 'Don`t Save model', 500);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'posts' => $posts,
            ]);
        }
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $posts = $model->blogLangs;
        $posts = BlogHelper::changeBlogKeys($posts);

        $model->setScenario(Blog::SCENARIO_UPDATE);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->loadBlogLangs($post['BlogLang']);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }else {
                throw new HttpException(500, 'Don`t Save model', 500);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'posts' => $posts,
            ]);
        }
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
