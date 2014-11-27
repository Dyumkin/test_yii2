<?php

namespace common\models;

use Yii;
use backend\models\CommentsModel;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $model_class
 * @property integer $model_id
 * @property integer $user_id
 * @property integer $guest_id
 * @property string $content
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property CommentsModel $modelClass
 * @property Guest $guest
 * @property Comments $parent
 * @property Comments[] $comments
 * @property User $user
 */
class Comments extends \yii\db\ActiveRecord
{

    /** Status banned */
    const STATUS_BANNED = 0;
    /** Status active */
    const STATUS_ACTIVE = 1;
    /** Status deleted */
    const STATUS_DELETED = 2;

    /**
     * @var null|array|\yii\db\ActiveRecord[] Comment children
     */
    protected $_children;

    /**
     * @var string Created date
     */
    private $_created;
    /**
     * @var string Updated date
     */
    private $_updated;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Require
            ['content', 'required'],

            // Model class
            ['model_class', 'exist', 'targetClass' => CommentsModel::className(), 'targetAttribute' => 'id'],
            // Model
            ['model_id', 'validateModelId'],
            // Parent ID
            [
                'parent_id',
                'exist',
                'targetAttribute' => 'id',
            ],
            // Content
            ['content', 'string']
        ];
    }

    /**
     * Model ID validation.
     *
     * @param string $attribute Attribute name
     * @param array $params Attribute params
     *
     * @return mixed
     */
    public function validateModelId($attribute, $params)
    {
        /** @var \yii\db\ActiveRecord $class */
        $class = CommentsModel::findIdentity($this->model_class);
        if ($class === null) {
            $this->addError($attribute, Yii::t('comments', 'ERROR_MSG_INVALID_MODEL_ID'));
        } else {
            $model = $class->name;
            if ($model::find()->where(['id' => $this->model_id]) === false) {
                $this->addError($attribute, Yii::t('comments', 'ERROR_MSG_INVALID_MODEL_ID'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'parent_id' => Yii::t('blog', 'Parent ID'),
            'model_class' => Yii::t('blog', 'Model Class'),
            'model_id' => Yii::t('blog', 'Model ID'),
            'user_id' => Yii::t('blog', 'User ID'),
            'guest_id' => Yii::t('blog', 'Guest ID'),
            'content' => Yii::t('blog', 'Content'),
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
    public function getModelClass()
    {
        /** @var \yii\db\ActiveRecord $class */
        $class = CommentsModel::find()->where(['id' => $this->model_class])->asArray()->one();
        $model = $class->name;
        return $this->hasOne($model::className(), ['id' => 'model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(Guest::className(), ['id' => 'guest_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Comments::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (!$this->user_id) {
                    $this->user_id = Yii::$app->user->id;
                }
                if (!$this->status_id) {
                    $this->status_id = self::STATUS_ACTIVE;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array Status array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_BANNED => Yii::t('comments', 'STATUS_BANNED'),
            self::STATUS_ACTIVE => Yii::t('comments', 'STATUS_ACTIVE'),
            self::STATUS_DELETED => Yii::t('comments', 'STATUS_DELETED')
        ];
    }

    /**
     * $_children getter.
     *
     * @return null|array|]yii\db\ActiveRecord[] Comments children
     */
    public function getChildren()
    {
        return $this->_children;
    }

    /**
     * $_children setter.
     *
     * @param array|\yii\db\ActiveRecord[] $value Comments children
     */
    public function setChildren($value)
    {
        $this->_children = $value;
    }

    /**
     * @return string Comment status
     */
    public function getStatus()
    {
        return self::getStatusArray()[$this->status_id];
    }

    /**
     * @return boolean Whether comment is active or not
     */
    public function getIsActive()
    {
        return $this->status_id === self::STATUS_ACTIVE;
    }
    /**
     * @return boolean Whether comment is banned or not
     */
    public function getIsBanned()
    {
        return $this->status_id === self::STATUS_BANNED;
    }
    /**
     * @return boolean Whether comment is deleted or not
     */
    public function getIsDeleted()
    {
        return $this->status_id === self::STATUS_DELETED;
    }

    /**
     * Get comments tree.
     *
     * @param integer $model Model ID
     * @param integer $class Model class ID
     *
     * @return array|\yii\db\ActiveRecord[] Comments tree
     */
    public static function getTree($model, $class)
    {
        $models = self::find()->where([
            'model_id' => $model,
            'model_class' => $class
        ])->orderBy(['parent_id' => 'ASC', 'created_at' => 'ASC'])->all();
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
     * @return array|\yii\db\ActiveRecord[] Comments tree
     */
    protected static function buildTree(&$data, $rootID = 0)
    {
        $tree = [];
        foreach ($data as $id => $node) {
            if ($node->parent_id == $rootID) {
                unset($data[$id]);
                $node->children = self::buildTree($data, $node->id);
                $tree[] = $node;
            }
        }
        return $tree;
    }
    /**
     * Delete comment.
     *
     * @return boolean Whether comment was deleted or not
     */
    public function deleteComment()
    {
        $this->status_id = self::STATUS_DELETED;
        $this->content = '';
        return $this->save(false, ['status_id', 'content']);
    }

    /**
     * @return string Created date
     */
    public function getCreated()
    {
        if ($this->_created === null) {
            $this->_created = Yii::$app->formatter->asDate($this->created_at, 'd LLL Y');
        }
        return $this->_created;
    }
    /**
     * @return string Updated date
     */
    public function getUpdated()
    {
        if ($this->_updated === null) {
            $this->_updated = Yii::$app->formatter->asDate($this->updated_at, 'd LLL Y');
        }
        return $this->_updated;
    }


}
