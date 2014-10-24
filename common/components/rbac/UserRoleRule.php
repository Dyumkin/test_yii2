<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 24.10.14
 * Time: 11:04
 * To change this template use File | Settings | File Templates.
 */

namespace common\components\rbac;


use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use common\models\User;

class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {

        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {
            $role = $user->role;
            if ($item->name === 'admin') {
                return $role == User::ROLE_ADMIN;
            }
            elseif ($item->name === 'user') {
                return $role == User::ROLE_ADMIN || $role == User::ROLE_USER;
            }
        }
        return false;
    }
}