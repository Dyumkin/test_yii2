<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 06.11.14
 * Time: 8:13
 * To change this template use File | Settings | File Templates.
 */

/**
 * Blog page view.
 *
 * @var \yii\web\View $this View
 * @var  \common\models\Blog $model Model
 */

$this->title = $model->content->title;
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('blog', 'BACKEND_INDEX_TITLE'),
        'url' => ['index']
    ],
    $this->title
]; ?>
<div class="row">
    <div class="blog">
        <div class="blog-item">

            <div class="blog-content">
                <h3><?= $model->content->title ?></h3>

                <div class="entry-meta">
                    <span><i class="icon-calendar"></i> <?= $model->created_at ?></span>
                    <span><i class="icon-eye-open"></i> <?= $model->views ?></span>
                </div>
                <?= $model->content->content ?>

                <?php echo \frontend\widgets\Comment::widget(
                            [
                                'model' => $model,
                                'jsOptions' => [
                                    'offset' => 80
                                ]
                            ]
                        ); ?>

            </div>
        </div>
        <!--/.blog-item-->
    </div>
</div><!--/.row-->