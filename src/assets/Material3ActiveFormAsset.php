<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace neoacevedo\yii2\material3\assets;

use yii\web\AssetBundle;

/**
 * The asset bundle for the [[ActiveForm]] widget.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Material3ActiveFormAsset extends AssetBundle
{
    public $sourcePath = '@vendor/neoacevedo/yii2-material3/src/assets/dist';

    public $css = [
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined',
    ];

    public $js = [
        'js/bundle.js',
        'js/yii2-material3.min.js',
    ];

    public $depends = [
        Material2MdcCardAsset::class
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

}
