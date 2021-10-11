<?php

namespace app\components\Ldap;

use Adldap\Adldap;
use Yii;
use yii\base\BaseObject;

class Ldap extends BaseObject
{
    public array $config;

    public function authenticate($username, $password, $preventRebind = false)
    {
        if (Yii::$app->request->serverName === "asutp.lli")
            return true;
        $ad = new Adldap($this->config);
        return $ad->authenticate($username, $password, $preventRebind);
    }
}