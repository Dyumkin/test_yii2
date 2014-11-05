<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Lang;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $posts[] common\models\BlogLang */
/* @var $post common\models\BlogLang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin([
        'id' => 'blog-form',
        'options' => ['class' => 'form-horizontal'],
    ]); ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 100]) ?>

    <?php foreach ( $posts as $lang => $post): ?>

        <?php if (isset($post->id)): ?>

            <?= Html::activeHiddenInput($post, 'id', ['name' => 'BlogLang['.$lang.'][id]']); ?>

        <?php endif; ?>

        <?= Html::label(Lang::getLangByUrl($lang)->name); ?>

                <?= $form->field($post, 'title', ['enableClientValidation' => false])->textInput(['name' => 'BlogLang['.$lang.'][title]']); ?>

                <?= $form->field($post, 'snippet')->textarea(['name' => 'BlogLang['.$lang.'][snippet]']); ?>

                <?= $form->field($post, 'content')->textarea(['name' => 'BlogLang['.$lang.'][content]']); ?>

    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>

