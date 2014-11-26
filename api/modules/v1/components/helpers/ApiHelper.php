<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 24.11.14
 * Time: 10:10
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\components\helpers;

class ApiHelper {

    /**
     * @param \yii\db\ActiveRecord $model
     * @param $relationName string
     * @return array
     */
    public static function getRelationData(\yii\db\ActiveRecord $model, $relationName)
    {
        $relation = $model->getRelation($relationName)->asArray()->all();

        $classPath = explode("\\", get_class($model));

        $className = end($classPath);

        $data = [
            $className => $model,
            $relationName => $relation
        ];

        return $data;
    }
}