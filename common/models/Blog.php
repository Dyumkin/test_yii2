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
            'alias' => Yii::t('blog', 'ALIAS'),
            'views' => Yii::t('blog', 'VIEWS'),
            'status_id' => Yii::t('blog', 'STATUS'),
            'created_at' => Yii::t('blog', 'CREATE_DATE'),
            'updated_at' => Yii::t('blog', 'UPDATE_DATE'),
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

    public function loadBlogLangs($blogs)
    {
        $posts = [];
        foreach($blogs as $lang => $data)
        {
            if(isset($data['id']) && !empty($data['id']))
            {
                $post = BlogLang::findOne($data['id']);
                $post->setAttributes($data);
            } else {
                $post = new BlogLang($data);
                $post->lang_id = Lang::getLangByUrl($lang)->id;
            }
            $posts[] = $post;
        }

        $this->setBlogLangs($posts);
    }

    public function behaviors()
    {
        return [
            'dateTimeStampBehavior' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ]
            ]
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord){
            $this->status_id = self::STATUS_UNPUBLISHED;
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {

        $relatedRecords = $this->getRelatedRecords();

        if (isset($relatedRecords['blogLangs'])) {
            foreach($relatedRecords['blogLangs'] as $blog){
                $this->link('blogLangs', $blog);
            }
        }
    }

    /**
     * @return bool
     */
    public function updateViews()
    {
        return $this->updateCounters(['views' => 1]);
    }

    /**
     * @return string Readable blog status
     */
    public function getStatus()
    {
        $statuses = self::getStatusArray();
        return $statuses[$this->status_id];
    }
    /**
     * @return array Status array.
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_UNPUBLISHED => Yii::t('blog', 'STATUS_UNPUBLISHED'),
            self::STATUS_PUBLISHED => Yii::t('blog', 'STATUS_PUBLISHED')
        ];
    }

    /**
     * @param $status int
     * @return bool|int
     */
    public function updateStatus($status)
    {
        $statuses = self::getStatusArray();

        if (!array_key_exists($status, $statuses))
        {
            return false;
        }

        return $this->updateAttributes(['status_id' => $status]);
    }
}
