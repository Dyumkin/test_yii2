<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Lang;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $content common\models\BlogLang */
/* @var $language common\models\Lang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 100]) ?>


    <?php foreach (ArrayHelper::map(Lang::find()->asArray()->all(), 'id', 'name') as $langName): ?>
        <div class="form-group-blog">
            <?= Html::label($langName, null, ['class'=>'col-sm-2 control-label']) ?>

            <div class="col-sm-2">
                <?= $form->field($content, 'title')->textInput(); ?>
            </div>

            <div class="col-sm-2">
                <?= $form->field($content, 'snippet')->textInput(); ?>
            </div>

            <div class="col-sm-3">
                <?= $form->field($content, 'content')->textInput(); ?>
            </div>
        </div>
    <?php endforeach; ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
