<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 24.10.14
 * Time: 14:37
 * To change this template use File | Settings | File Templates.
 */

use yii\helpers\Html;
?>

<div id="lang">
    <span id="current-lang">
        <?= $current->name;?> <span class="show-more-lang">▼</span>
    </span>
    <ul id="langs">
        <?php foreach ($langs as $lang):?>
            <li class="item-lang">
                <?= Html::a($lang->name, '/'.$lang->url.Yii::$app->getRequest()->getUrl()) ?>
            </li>
        <?php endforeach;?>
    </ul>
</div>