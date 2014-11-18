<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 17.11.14
 * Time: 7:12
 * To change this template use File | Settings | File Templates.
 */

namespace backend\models\search;

use Yii;
use backend\models\CommentsModel;
use common\models\Comments;
use yii\data\ActiveDataProvider;

class CommentsSearch extends Comments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Integer
            [['id', 'parent_id', 'model_id', 'model_class'], 'integer'],
            // String
            ['content', 'string'],
            // Status
            ['status_id', 'in', 'range' => array_keys(self::getStatusArray())],
            // Date
            [['created_at', 'updated_at'], 'date', 'format' => 'd.m.Y']
        ];
    }
    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params Search params
     *
     * @return ActiveDataProvider DataProvider
     */
    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(
            [
                'id' => $this->id,
                'parent_id' => $this->parent_id,
                'model_id' => $this->model_id,
                'model_class' => $this->model_class,
                'status_id' => $this->status_id,
                'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at,
                'FROM_UNIXTIME(updated_at, "%d.%m.%Y")' => $this->updated_at
            ]
        );
        $query->andFilterWhere(['like', 'content', $this->content]);
        return $dataProvider;
    }
}