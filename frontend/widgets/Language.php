<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 24.10.14
 * Time: 14:34
 * To change this template use File | Settings | File Templates.
 */

namespace frontend\widgets;

use common\models\Lang;

class Language extends \yii\bootstrap\Widget
{
    public function init(){}

    public function run() {
        return $this->render('lang/view', [
            'current' => Lang::getCurrent(),
            'langs' => Lang::find()->where('id != :current_id', [':current_id' => Lang::getCurrent()->id])->all(),
        ]);
    }
}