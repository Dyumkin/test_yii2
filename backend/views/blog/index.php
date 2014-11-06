<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var array $statusArray Statuses array */

$this->title = Yii::t('blog', 'Blogs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('blog', 'Create {modelClass}', [
    'modelClass' => 'Blog',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',

            [
                'attribute' => 'alias',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(
                        $model['alias'],
                        ['view', 'id' => $model['id']]
                    );
                }
            ],

            'views',
            [
                'attribute' => 'status_id',
                'format' => 'html',
                'value' => function ($model) {
                    $class = ($model->status_id === $model::STATUS_PUBLISHED) ? 'btn btn-success' : 'btn btn-danger';
                    return Html::a($model->status, ['updateStatus', 'id' => $model->id], ['class' => $class]);

                    //return '<span class="label ' . $class . '">' . $model->status . '</span>';
                },

            ],

            [
                'attribute' => 'created_at',
                'format' => 'datetime',

            ],

            [
                'attribute' => 'updated_at',
                'format' => 'datetime',

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
