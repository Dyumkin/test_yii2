<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "guest".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property integer $status_id
 * @property integer $is_registration
 * @property string $server_information
 *
 * @property Comments[] $comments
 */
class Guest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['status_id', 'is_registration'], 'integer'],
            [['server_information'], 'string'],
            [['username', 'email'], 'string', 'max' => 255],
            [['email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'username' => Yii::t('blog', 'Username'),
            'email' => Yii::t('blog', 'Email'),
            'status_id' => Yii::t('blog', 'Status ID'),
            'is_registration' => Yii::t('blog', 'Is Registration'),
            'server_information' => Yii::t('blog', 'Server Information'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['guest_id' => 'id']);
    }
}
