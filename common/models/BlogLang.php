<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_lang".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $lang_id
 * @property string $title
 * @property string $snippet
 * @property string $content
 *
 * @property Lang $lang
 * @property Blog $post
 */
class BlogLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'lang_id'], 'integer'],
            [['title', 'snippet', 'content'], 'required'],
            [['snippet', 'content'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['title', 'snippet', 'content'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'post_id' => Yii::t('blog', 'Post ID'),
            'lang_id' => Yii::t('blog', 'Lang ID'),
            'title' => Yii::t('blog', 'Title'),
            'snippet' => Yii::t('blog', 'Snippet'),
            'content' => Yii::t('blog', 'Content'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Blog::className(), ['id' => 'post_id']);
    }
}
