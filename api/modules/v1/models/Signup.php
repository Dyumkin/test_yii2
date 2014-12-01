<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 01.12.14
 * Time: 8:09
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\models;


use frontend\models\SignupForm;
use Yii;

class Signup extends SignupForm{

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();

            $auth = Yii::$app->authManager;
            $authorRole = $auth->getRole('user');
            $auth->assign($authorRole, $user->getId());

            return $user;
        }

        return null;
    }
}