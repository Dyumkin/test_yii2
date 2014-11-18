<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 17.11.14
 * Time: 7:06
 * To change this template use File | Settings | File Templates.
 */

namespace backend\models\search;

use Yii;
use backend\models\CommentsModel;
use yii\data\ActiveDataProvider;
/**
 * Comment models search model.
 */
class CommentsModelSearch extends CommentsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Integer
            ['id', 'integer'],
            // String
            ['name', 'string', 'max' => 255],
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
                'status_id' => $this->status_id,
                'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at,
                'FROM_UNIXTIME(updated_at, "%d.%m.%Y")' => $this->updated_at
            ]
        );
        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}