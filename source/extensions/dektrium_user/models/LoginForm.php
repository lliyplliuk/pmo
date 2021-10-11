<?php

namespace app\extensions\dektrium_user\models;


use dektrium\user\models\LoginForm as ParentLoginForm;
use dektrium\user\models\RegistrationForm;
use Yii;

class LoginForm extends ParentLoginForm
{
    public function rules()
    {
        $return = parent::rules();
        $return['passwordValidate'] = ['password', function ($attribute) {
            if (!(Yii::$app->ldap->authenticate($this->login, $this->password))) {
                $this->addError($attribute, \Yii::t('user', 'Invalid login or password'));
            }
        }];
        return $return;
    }

    public function login()
    {
        if (empty($this->user)) {
            $model = new RegistrationForm;
            $model->email = $this->login . "@suek.ru";
            $model->username = $this->login;
            $model->password = $this->login;
            $model->register();
            $this->user = $this->finder->findUserByUsernameOrEmail($this->login);
        }
        if ($this->validate() && $this->user) {
            $isLogged = Yii::$app->getUser()->login($this->user, $this->rememberMe ? $this->module->rememberFor : 0);
            if ($isLogged) {
                $this->user->updateAttributes(['last_login_at' => time()]);
            }
            return $isLogged;
        }

        return false;
    }
}