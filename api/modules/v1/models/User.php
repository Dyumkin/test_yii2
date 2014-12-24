<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 19.11.14
 * Time: 11:50
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\models;

use Yii;
use common\models\User as CommonUser;
use yii\helpers\ArrayHelper;

class User extends CommonUser
{

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    public function setAccessToken()
    {
        Yii::$app->getResponse()->getHeaders()->set('WWW-Authenticate', "Bearer realm=\"{$this->access_token}\"");
    }

}