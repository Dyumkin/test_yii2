<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "blog".
 *
 * @property integer $id
 * @property string $alias
 * @property integer $views
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BlogLang[] $blogLangs
 */
class Blog extends \yii\db\ActiveRecord
{
    /** Unpublished status **/
    const STATUS_UNPUBLISHED = 0;
    /** Published status **/
    const STATUS_PUBLISHED = 1;

    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['views', 'status_id', 'created_at', 'updated_at'], 'integer'],
            [['alias'], 'string', 'max' => 100]
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_INSERT => ['alias'],
            self::SCENARIO_UPDATE => ['alias'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'alias' => Yii::t('blog', 'Alias'),
            'views' => Yii::t('blog', 'Views'),
            'status_id' => Yii::t('blog', 'Status ID'),
            'created_at' => Yii::t('blog', 'Created At'),
            'updated_at' => Yii::t('blog', 'Updated At'),
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_INSERT => self::OP_INSERT,
            self::SCENARIO_UPDATE => self::OP_UPDATE,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogLangs()
    {
        return $this->hasMany(BlogLang::className(), ['post_id' => 'id']);
    }

    public function getContent($lang_id=null)
    {
        $lang_id = ($lang_id === null)? Lang::getCurrent()->id: $lang_id;

        return $this->hasOne(BlogLang::className(), ['post_id' => 'id'])->where('lang_id = :lang_id', [':lang_id' => $lang_id]);
    }

    public function setBlogLangs($posts)
    {
        $this->populateRelation('blogLangs', $posts);

    }

    public function behaviors()
    {
        return [
            'dateTimeStampBehavior' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['create_at', 'update_at'],
                    self::EVENT_BEFORE_UPDATE => 'update_at',
                ]
            ]
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {

        $relatedRecords = $this->getRelatedRecords();

        if (isset($relatedRecords['blogLangs'])) {
            foreach ($relatedRecords['blogLangs'] as $blogLang) {
                $this->link('blogLangs', $blogLang);
            }
        }
    }

/*    public function loadBlogLangs($blogLangs)
    {
        $posts = [];

        foreach ($blogLangs as $lang => $value) {
            $post = new BlogLang();
            $post->title = $value->name;
            $post->content = $value->content;
            $post->snippet = $value->snippet;
            $posts[] = $post;
        }

        $this->setBlogLangs($posts);
    }*/

}
