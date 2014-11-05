<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $posts[] common\models\BlogLang */

$this->title = Yii::t('blog', 'Update {modelClass}: ', [
    'modelClass' => 'Blog',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blog', 'Update');
?>
<div class="blog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'posts' => $posts,
    ]) ?>

</div>
