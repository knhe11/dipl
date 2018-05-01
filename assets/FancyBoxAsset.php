<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FancyBoxAsset extends AssetBundle
{
    public $sourcePath = '@bower/fancybox/dist';

    public $css = [
        'jquery.fancybox.min.css',
    ];
    public $js = [
        'jquery.fancybox.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
