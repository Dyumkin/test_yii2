<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 06.11.14
 * Time: 7:36
 * To change this template use File | Settings | File Templates.
 */

/**
 * Blog list item view.
 *
 * @var \yii\web\View $this View
 * @var \common\models\Blog $model Model
 */


use yii\helpers\Html;

?>
<?php if (!empty($model->content)): ?>
<div class="blog-content">
    <h3>
        <?= Html::a($model->content->title, ['view', 'id' => $model->id]) ?>
    </h3>

    <div class="entry-meta">
        <span><i class="icon-calendar"></i> <?= $model->created_at ?></span>
        <span><i class="icon-eye-open"></i> <?= $model->views ?></span>
    </div>
    <?= $model->content->snippet ?>
    <?= Html::a(
        Yii::t('blog', 'FRONTEND_INDEX_READ_MORE_BTN') . ' <i class="icon-angle-right"></i>',
        ['view', 'id' => $model->id],
        ['class' => 'btn btn-default']
    ) ?>
</div>
<?php endif; ?>