<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 17.11.14
 * Time: 9:39
 * To change this template use File | Settings | File Templates.
 */

/**
 * Comment model create view.
 *
 * @var \yii\base\View $this View
 * @var backend\models\CommentsModel $model Model
 * @var array $statusArray Statuses array
 */

$this->title = Yii::t('comments-models', 'BACKEND_CREATE_TITLE');
$this->params['subtitle'] = Yii::t('comments-models', 'BACKEND_CREATE_SUBTITLE');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
]; ?>
<div class="row">
    <div class="col-sm-12">
        <?php echo $this->render(
            '_form',
            [
                'model' => $model,
                'statusArray' => $statusArray,
            ]
        );
        ?>
    </div>
</div>