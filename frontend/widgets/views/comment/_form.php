<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 17.11.14
 * Time: 8:14
 * To change this template use File | Settings | File Templates.
 */

/**
 * Comments widget form view.
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var common\models\Comments $model New comment model
 */

use yii\helpers\Html;
?>

<?= Html::beginForm(['/comment/create'], 'POST', ['class' => 'form-horizontal', 'data-comment' => 'form', 'data-comment-action' => 'create']) ?>
    <div class="form-group" data-comment="form-group">
        <div class="col-sm-12">
            <?= Html::activeTextarea($model, 'content', ['class' => 'form-control']) ?>
            <?= Html::error($model, 'content', ['data-comment' => 'form-summary', 'class' => 'help-block hidden']) ?>
        </div>
    </div>
<?= Html::activeHiddenInput($model, 'parent_id', ['data-comment' => 'parent-id']) ?>
<?= Html::activeHiddenInput($model, 'model_class') ?>
<?= Html::activeHiddenInput($model, 'model_id') ?>
<?= Html::submitButton(Yii::t('comments', 'FRONTEND_WIDGET_COMMENTS_FORM_SUBMIT'), ['class' => 'btn btn-danger btn-lg']); ?>
<?= Html::endForm(); ?>