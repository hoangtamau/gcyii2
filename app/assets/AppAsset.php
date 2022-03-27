<?php

namespace app\assets;

class AppAsset extends \yii\web\AssetBundle {

    public $sourcePath = '@app/media';
    public $css = [
        
        'css/eauth-min.css',
        'css/main-min.css',
        'css/style-min.css',
    ];
    public $js = [
        'js/script.js',
        'js/min.eauth.js',
        //'js/tuyetroi.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
