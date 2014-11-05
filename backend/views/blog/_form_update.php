<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 04.11.14
 * Time: 9:57
 * To change this template use File | Settings | File Templates.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Lang;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $content common\models\BlogLang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin([
        'id' => 'blog-form',
        'options' => ['class' => 'form-horizontal'],
    ]); ?>

    <?= $form->field($content, 'lang_id')->label(); ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($content, 'title')->textInput(); ?>

    <?= $form->field($content, 'snippet')->textarea(); ?>

    <?= $form->field($content, 'content')->textarea(); ?>





    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>