<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 19.11.14
 * Time: 11:50
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\models;

use common\models\User as CommonUser;

class User extends CommonUser
{

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

}