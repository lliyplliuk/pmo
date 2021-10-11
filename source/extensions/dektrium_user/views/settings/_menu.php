<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use app\extensions\dektrium_user\widgets\UserMenu;

/**
 * @var dektrium\user\models\User $user
 */

$user = Yii::$app->user->identity;
?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            <?= $user->username ?>
        </h5>

        <?= UserMenu::widget() ?>
    </div>
</div>
