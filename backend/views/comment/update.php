<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 17.11.14
 * Time: 8:06
 * To change this template use File | Settings | File Templates.
 */

/**
 * Comment update view.
 *
 * @var \yii\base\View $this View
 * @var common\models\Comments $model Model
 * @var array $statusArray Status array
 */


$this->title = Yii::t('comments', 'BACKEND_UPDATE_TITLE');
$this->params['subtitle'] = Yii::t('comments', 'BACKEND_UPDATE_SUBTITLE');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];
$boxButtons = ['{cancel}'];
if (Yii::$app->user->can('BDeleteComments')) {
    $boxButtons[] = '{delete}';
}
$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>
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