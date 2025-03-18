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

namespace neoacevedo\yii2\material\widgets;

use neoacevedo\yii2\material\Html;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * NavigationDrawer renderiza el componente web NavigationDrawer.
 * 
 * Dado que Material 3 no dispone del componente en web, se crea uno desde 0.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://m3.material.io/components/navigation-drawer/guidelines
 */
class NavigationDrawer extends Widget
{

    const DRAWER_MODAL = 'modal';
    //const DRAWER_BOTTOM = 'bottom';
    const DRAWER_DISMISSIBLE = 'dismissible';

    /**
     * @var array Lista de los elementos del Navigation Drawer. 
     * 
     * Ver [[Html::list()]] para conocer la estructura del array.
     * @see https://m3.material.io/components/navigation-drawer/guidelines#86ff751b-e510-4428-bfb2-cc5bf9206bb8
     */
    public array $items = [];

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered. The following options are specially handled:
     * 
     * - type: string, [[self::DRAWER_MODAL]] or [[self::DRAWER_DISMISSIBLE]].
     * 
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $options = [];

    public function init(): void
    {
        $this->options = array_merge([
            'id' => $this->getId(),
        ], $this->options);

    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        echo Html::beginTag(name: 'md-navigation-drawer', options: $this->options) . "\n";
        // if ($this->menuButton) {
        //     echo Html::tag(name: 'div', content: $this->menuButton, options: ['slot' => 'menu']) . "\n";
        // }
        echo Html::tag(name: 'span', content: '', options: ['slot' => 'title']) . "\n";

        echo Html::beginTag(name: 'div', options: ['class' => 'navigation-rail-content', 'slot' => 'content']) . "\n";
        $this->renderItems();
        echo Html::endTag(name: 'div') . "\n";

        echo Html::endTag(name: 'md-navigation-drawer') . "\n";
    }

    /**
     * Renderiza los elementos del Navigation Drawer.
     * @return void
     * @throws \yii\base\InvalidConfigException
     */
    protected function renderItems(): void
    {
        echo Html::list(items: $this->items, options: $this->options);
    }
}