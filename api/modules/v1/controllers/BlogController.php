<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 19.11.14
 * Time: 4:50
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class BlogController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Blog';
}