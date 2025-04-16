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

use yii\base\View;
use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;

/**
 * Material 3 Asset.
 */
class MaterialAsset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $sourcePath = '@vendor/neoacevedo/yii2-material/src/assets/dist';

    /**
     * @inheritDoc
     */
    public $css = [
        'css/yii2-material.min.css',
    ];

    /**
     * @inheritDoc
     */
    public $js = [
        'js/yii2-material.min.js',
        'js/top-app-bar.min.js',
        'js/navigation-rail.min.js',
        'js/navigation-drawer.min.js',
        'js/card.min.js',
        'js/snackbar.min.js',
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


    public static function publishMaterialScripts(): string
    {
        $script = <<<HTML
            <script type="importmap">
                {
                    "imports": {
                        "@material/web/": "https://esm.run/@material/web/"
                    }
                }
            </script>
            <script type="module">
                import "@material/web/all.js";
                import { styles as typescaleStyles } from '@material/web/typography/md-typescale-styles.js';
                document.adoptedStyleSheets.push(typescaleStyles.styleSheet);
            </script>
        HTML;

        return $script;
    }

}
