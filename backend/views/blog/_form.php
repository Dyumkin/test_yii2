<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Lang;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $content common\models\BlogLang */
/* @var $language common\models\Lang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 100]) ?>


    <?= $form->field($content, 'lang_id')->dropDownList(ArrayHelper::map(Lang::find()->asArray()->all(), 'id', 'name')); ?>

                <?= $form->field($content, 'title')->textInput(); ?>

                <?= $form->field($content, 'snippet')->textarea(); ?>

                <?= $form->field($content, 'content')->textarea(); ?>





    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>

