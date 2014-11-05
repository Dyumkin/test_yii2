<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $posts[] common\models\BlogLang */

$this->title = Yii::t('blog', 'Create {modelClass}', [
    'modelClass' => 'Blog',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'posts' => $posts,
    ]) ?>

</div>
