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
    public $sourcePath = '@vendor/neoacevedo/yii2-material/src/assets/src';

    public $css = [
        'mdc/node_modules/@material/web/typography/md-typescale-styles.css',
        'css/yii2-material.scss',
        'css/yii2-md-top-app-bar.scss',
    ];

    public $js = [
        'js/bundle.js',
        'js/yii2-material.js',
        'js/top-app-bar.js'
    ];

    public $depends = [
        Material2MdcCardAsset::class,
        Material2MdcSnackbarAsset::class,
        Material2MdcNavigationDrawerAsset::class,
        // Material2MdcTopAppBarAsset::class,
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public function registerAssetFiles($view): void
    {
        parent::registerAssetFiles($view);
        $manager = $view->getAssetManager();
        $cssContent = file_get_contents(filename: $manager->getAssetPath(bundle: $this, asset: 'mdc/node_modules/@material/web/typography/md-typescale-styles.css'));
        $cssContent .= file_get_contents(filename: $manager->getAssetPath(bundle: $this, asset: 'css/yii2-md-top-app-bar.css'));
        $view->registerJs(js: "window.topAppBarStyles = `$cssContent`;", position: \yii\web\View::POS_HEAD, key: 'topAppBarStyles');
    }

}
