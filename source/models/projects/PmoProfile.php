<?php

namespace app\models\projects;


use dektrium\user\models\Profile;

class PmoProfile
{
    private static array $cache;

    public static function getProfile($id_author): Profile
    {
        if (!isset(PmoProfile::$cache[$id_author])) {
            $profile = Profile::find()->where(['user_id' => $id_author])->one();
            PmoProfile::$cache[$id_author] = $profile;
        }
        return PmoProfile::$cache[$id_author];
    }
}
