<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 17.11.14
 * Time: 8:12
 * To change this template use File | Settings | File Templates.
 */

/**
 * Comments list view.
 *
 * @var \yii\web\View $this View
 * @var common\models\Comments[] $models Comments models
 * @var common\models\Comments $model New comment model
 */

?>

<div id="comments">
    <div id="comments-list" data-comment="list">
        <?= $this->render('_index_item', ['models' => $models]) ?>
    </div>
    <!--/ #comments-list -->

    <?php /*if (Yii::$app->user->can('createComments')) :*/ ?>
        <h3><?= Yii::t('comments', 'FRONTEND_WIDGET_COMMENTS_FORM_TITLE') ?></h3>
        <?= $this->render('_form', ['model' => $model]); ?>
    <?php /*endif;*/ ?>
</div>