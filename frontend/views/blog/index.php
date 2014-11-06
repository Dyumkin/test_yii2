<?php
/**
 * Blog list page view.
 *
 * @var \yii\web\View $this View
 * @var \yii\data\ActiveDataProvider $dataProvider DataProvider
 */

use yii\widgets\ListView;

$this->title = Yii::t('blog', 'FRONTEND_INDEX_TITLE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{pager}",
                'itemView' => '_index_item',
                'options' => [
                    'class' => 'blog'
                ],
                'itemOptions' => [
                    'class' => 'blog-item',
                    'tag' => 'article'
                ]
            ]
        ); ?>
</div>
