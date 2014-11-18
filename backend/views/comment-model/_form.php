<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 17.11.14
 * Time: 9:38
 * To change this template use File | Settings | File Templates.
 */

/**
 * Comment model form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var backend\models\CommentsModel $model Model
 * @var array $statusArray Statuses array
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12">
            <?=
            $form->field($model, 'name')->textInput(['placeholder' => Yii::t('comments-models', 'BACKEND_CREATE_PLACEHOLDER_NAME')]) ?>
        </div>
    </div>
<?= Html::submitButton(
    $model->isNewRecord ? Yii::t('comments-models', 'BACKEND_CREATE_SUBMIT') : Yii::t('comments-models', 'BACKEND_UPDATE_SUBMIT'),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php ActiveForm::end(); ?>