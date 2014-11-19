<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 19.11.14
 * Time: 11:50
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\models;

use yii\base\NotSupportedException;

class User extends \common\models\User
{

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO сделать
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented бла бла бла.');
    }

}