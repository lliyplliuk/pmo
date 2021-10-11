<?php

namespace app\assets\pmoGantt;

use yii\web\AssetBundle;

class PmoGanttAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/pmoGantt';

    public $css = [
        'css/gantt.css?v=4',
        'css/platform.css?1',
        'js/jquery/valueSlider/mb.slider.css',
        'js/jquery/dateField/jquery.dateField.css',
    ];
    public $js = [
        'js/jquery/jquery-ui.min.js',
        'js/jquery/jquery.livequery.1.1.1.min.js',
        'js/jquery/jquery.timers.js',
        'js/utilities.js',
        'js/forms.js',
        'js/date.js',
        'js/dialogs.js?3',
        'js/layout.js',
        'js/i18nJs.js',
        'js/jquery/dateField/jquery.dateField.js',
        'js/jquery/JST/jquery.JST.js',
        'js/jquery/valueSlider/jquery.mb.slider.js',
        'js/jquery/svg/jquery.svg.min.js',
        'js/jquery/svg/jquery.svgdom.1.8.js',
        'js/ganttUtilities.js',
        'js/ganttTask.js?4',
        'js/ganttDrawerSVG.js?3',
        'js/ganttZoom.js',
        'js/ganttGridEditor.js?5',
        'js/ganttMaster.js?2',
        'js/gantAdd.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
     ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}