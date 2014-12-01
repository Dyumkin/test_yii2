<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 21.11.14
 * Time: 8:50
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\components\blog;

use Yii;
use yii\rest\IndexAction as RestIndex;
use yii\data\ActiveDataProvider;

class IndexAction extends RestIndex
{

    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        return new ActiveDataProvider([
            'query' => $modelClass::find()->with('blogLangs')->asArray(),
            'pagination' => [
                'pageSize' => Yii::$app->params['api.blog.pageSize']
            ]
        ]);
    }
}