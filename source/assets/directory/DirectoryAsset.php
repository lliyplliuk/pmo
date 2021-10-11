<?php

namespace app\assets\directory;

use yii\web\AssetBundle;

class DirectoryAsset extends AssetBundle
{
    public $sourcePath  = '@app/assets/directory/src';

    public $css = [
    ];
    public $js = [
        'directory.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}