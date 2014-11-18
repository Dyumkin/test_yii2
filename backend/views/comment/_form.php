<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 17.11.14
 * Time: 8:03
 * To change this template use File | Settings | File Templates.
 */

/**
 * Comment form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var common\models\Comments $model Model
 * @var array $statusArray Statuses array
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'status_id')->dropDownList($statusArray, ['prompt' => Yii::t('comments', 'BACKEND_PROMPT_STATUS')]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'content')->textarea() ?>
        </div>
    </div>
<?= Html::submitButton(
    $model->isNewRecord ? Yii::t('comments', 'BACKEND_CREATE_SUBMIT') : Yii::t('comments', 'BACKEND_UPDATE_SUBMIT'),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php ActiveForm::end(); ?>