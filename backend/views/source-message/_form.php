<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SourceMessage */
/* @var $message backend\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="source-message-form">

    <?php $form = ActiveForm::begin(); ?>

     <?php foreach ($model->messages as $message): ?>

        <?= Html::label($message->language); ?>

        <?= $form->field($message, 'translation')->textInput(['name' => 'Message['.$message->language.'][translation]']); ?>

    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
