<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 17.11.14
 * Time: 8:10
 * To change this template use File | Settings | File Templates.
 */
namespace frontend\widgets;

use Yii;
use common\models\Comments;
use frontend\assets\AppAsset;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Json;

class Comment extends \yii\bootstrap\Widget
{
    /**
     * @var \yii\db\ActiveRecord|null Widget model
     */
    public $model;
    /**
     * @var array Comments Javascript plugin options
     */
    public $jsOptions = [];
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->model === null) {
            throw new InvalidConfigException('The "model" property must be set.');
        }
        $this->registerClientScript();
    }
    /**
     * @inheritdoc
     */
    public function run()
    {
        $class = $this->model;
        $class = crc32($class::className());
        $models = Comments::getTree($this->model->id, $class);
        $model = new Comments();
        $model->model_class = $class;
        $model->model_id = $this->model->id;
        return $this->render('comment/index', [
            'models' => $models,
            'model' => $model
        ]);
    }
    /**
     * Register widget client scripts.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        $options = Json::encode($this->jsOptions);
        AppAsset::register($view);
        $view->registerJs('jQuery.comments(' . $options . ');');
    }
}