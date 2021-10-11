<?php

namespace app\extensions\dektrium_user\widgets;

use dektrium\user\widgets\UserMenu as dektriumUserMenu;
use Yii;
use yii\bootstrap4\Nav;

class UserMenu extends dektriumUserMenu
{

    public function init()
    {
        parent::init();
        $this->items = [
            ['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],
        ];
    }

    function run()
    {
        return Nav::widget([
            'items' => $this->items,
        ]);
    }
}