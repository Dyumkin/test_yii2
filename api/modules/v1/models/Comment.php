<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 26.11.14
 * Time: 7:54
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\models;

use \common\models\Comments as CommonComment;

class Comment extends CommonComment
{

    /**
     * Get comments tree.
     *
     * @param integer $model Model ID
     * @param integer $class Model class ID
     *
     * @return array Comments tree
     */
    public static function getTree($model, $class)
    {
        $models = self::find()->where([
            'model_id' => $model,
            'model_class' => $class
        ])->orderBy(['parent_id' => 'ASC', 'created_at' => 'ASC'])->asArray()->all();
        if ($models !== null) {
            $models = self::buildTree($models);
        }
        return $models;
    }
    /**
     * Build comments tree.
     *
     * @param array $data Records array
     * @param int $rootID parent_id Root ID
     *
     * @return array Comments tree
     */
    protected static function buildTree(&$data, $rootID = 0)
    {
        $tree = [];
        foreach ($data as $id => $node) {
            if ($node['parent_id'] == $rootID) {
                unset($data[$id]);
                $node['children'] = self::buildTree($data, $node['id']);
                $tree[] = $node;
            }
        }
        return $tree;
    }
}