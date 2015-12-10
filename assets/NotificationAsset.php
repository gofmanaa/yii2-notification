<?php
/**
 * Created by PhpStorm.
 * User: gofmana
 * Date: 12/9/15
 * Time: 3:50 PM
 */

namespace gofmanaa\notification\assets;


use yii\web\AssetBundle;

class NotificationAsset extends AssetBundle
{
    public $sourcePath = '@gofmanaa/notification/widgets/assets';
    public $css = [
    ];

    public $js = [
        'js/notification.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}