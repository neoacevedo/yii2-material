<?php

/**
 * @copyright Copyright (c) 2024 neoacevedo
 * @subpackage yii2-material
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace neoacevedo\yii2\material\assets;

use yii\web\AssetBundle;

/**
 * Material 3 Asset.
 */
class MaterialAsset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $sourcePath = YII_DEBUG ? '@vendor/neoacevedo/yii2-material/src/assets/src' : '@vendor/neoacevedo/yii2-material/src/assets/dist';

    /**
     * @inheritDoc
     */
    public $css = [
        YII_DEBUG ? 'css/yii2-material.css' : 'css/yii2-material.min.css',
    ];

    /**
     * @inheritDoc
     */
    public $js = [
        'js/bundle.js',
        YII_DEBUG ? 'js/yii2-material.js' : 'js/yii2-material.min.css',
        YII_DEBUG ? 'js/top-app-bar.js' : 'js/top-app-bar.min.js',
        'js/navigation-drawer.js',
        'js/navigation-drawer-modal.js',
        YII_DEBUG ? 'js/navigation-rail.js' : 'js/navigation-rail.min.js',
        YII_DEBUG ? 'js/card.js' : 'js/card.min.js',
        YII_DEBUG ? 'js/snackbar.js' : 'js/snackbar.min.js',
    ];

    /**
     * @inheritDoc
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];

    /**
     * @inheritDoc
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    /**
     * @inheritDoc
     */
    public $jsOptions = ['position' => \yii\web\View::POS_END];

}
