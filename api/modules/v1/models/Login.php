<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 09.12.14
 * Time: 7:23
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\models;

use Yii;
use common\models\LoginForm;

class Login extends LoginForm{

    public $access_token;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['access_token', 'validateAccessToken'],
        ];
    }

    public function validateAccessToken($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, 'Incorrect access token.');
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if($this->access_token)
        {
            $this->_user = User::findIdentityByAccessToken($this->access_token);
            return $this->_user;
        } else
        {
            return parent::getUser();
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        } else {
            return false;
        }
    }



}