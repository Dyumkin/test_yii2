<?php

namespace backend\models;

use Yii;
use common\models\Comments;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "comments_models".
 *
 * @property string $id
 * @property string $name
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Comments[] $comments
 */
class CommentsModel extends \yii\db\ActiveRecord
{

    /** Status disabled */
    const STATUS_DISABLED = 0;
    /** Status enabled */
    const STATUS_ENABLED = 1;
    /** Model array cache key */
    const CACHE_MODEL_ARRAY = 'cache-model-array';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments_models';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
            ['name', 'required'],
            // String
            ['name', 'string', 'max' => 255],
            // Name
            ['name', 'unique'],
            // Status
            ['status_id', 'in', 'range' => array_keys(self::getStatusArray())],
            ['status_id', 'default', 'value' => self::STATUS_ENABLED]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'name' => Yii::t('blog', 'Name'),
            'status_id' => Yii::t('blog', 'Status ID'),
            'created_at' => Yii::t('blog', 'Created At'),
            'updated_at' => Yii::t('blog', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className()
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['model_class' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->id = crc32($this->name);
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete(self::CACHE_MODEL_ARRAY);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            Comments::deleteAll(['model_class' => $this->id]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Find model by ID.
     *
     * @param string|integer $id Model ID
     *
     * @return static|null Found model
     */
    public static function findIdentity($id)
    {
        $id = is_numeric($id) ? $id : crc32($id);
        return self::findOne($id);
    }

    /**
     * @return array Status array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_DISABLED => Yii::t('blog', 'STATUS_DISABLED'),
            self::STATUS_ENABLED => Yii::t('blog', 'STATUS_ENABLED')
        ];
    }

    /**
     * @return string Model readable status
     */
    public function getStatus()
    {
        return self::getStatusArray()[$this->status_id];
    }

    /**
     * @return array Model array
     */
    public static function getModelArray()
    {
        if (($array = Yii::$app->cache->get(self::CACHE_MODEL_ARRAY)) === false) {
            $array = ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
            Yii::$app->cache->set(self::CACHE_MODEL_ARRAY, $array);
        }
        return $array;
    }


}
