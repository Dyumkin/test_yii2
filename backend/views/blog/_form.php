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
    <div class="row">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 100]) ?>


    <?php foreach (ArrayHelper::map(Lang::find()->asArray()->all(), 'id', 'name') as $id => $langName): ?>

                <?= $form->field($content, 'title')->textInput( ['class' => 'lang-'.$id]); ?>

                <?= $form->field($content, 'snippet')->widget(CKEditor::className(), [
            'options' => [
                'rows' => 4,
                'class' => 'lang-'.$id
            ],

        ]); ?>

                <?= $form->field($content, 'content')->widget(CKEditor::className(), [
            'options' => [
                'rows' => 4,
                'class' => 'lang-'.$id
            ],
            'clientOptions' => require(__DIR__ . '/../../../common/config/ckeditor/full-config.php')
        ]); ?>


    <?php endforeach; ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
