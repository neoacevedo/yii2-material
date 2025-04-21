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

namespace neoacevedo\yii2\material\widgets; // Ajusta el namespace

use neoacevedo\yii2\material\Html;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Menu se encarga de renderizar el componente Menu de Material Web.
 * 
 * Los data-* atributos no funcionan para este componente en Material Design Components para la web, por lo que se tendrán que programar los elementos que tengan estos atributos de manera separada.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://material-web.dev/components/menu/
 * @see https://m3.material.io/components/menus/overview
 */
class Menu extends Widget
{
    const POSITION_ABSOLUTE = 'absolute';
    const POSITION_DOCUMENT = 'document';
    const POSITION_FIXED = 'fixed';
    const POSITION_RELATIVE = 'relative';

    public $items = [];
    public $options = []; // Opciones para el contenedor del menú (<ul>)

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $this->options = ArrayHelper::merge(['id' => $this->id], $this->options); // Clase base de Material
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        echo Html::beginTag('md-menu', $this->options);

        echo $this->renderItems($this->items);

        echo Html::endTag('md-menu');
    }

    /**
     * Summary of renderItems
     * @return string
     */
    protected function renderItems(array $items): string
    {
        $lines = [];
        foreach ($items as $item) {
            $menu = (!empty($item['items'])) ? $this->renderSubMenu($item) : $this->renderItem($item);
            $lines[] = $menu;
        }
        return implode("\n", $lines);

    }

    /**
     * Summary of renderSubMenu
     * @param array $item
     * @return string
     */
    protected function renderSubMenu(array $item): string
    {
        $html = Html::beginTag('md-sub-menu', $item['options'] ?? []) . "\n";
        $item['options']['slot'] = 'item';
        $html .= $this->renderItem($item);

        $html .= Html::beginTag('md-menu', array_merge($item['menuOptions'] ?? [], ['slot' => 'menu'])) . "\n";
        $html .= $this->renderItems($item['items']);
        $html .= Html::endTag('md-menu') . "\n";

        $html .= Html::endTag('md-sub-menu') . "\n";
        return $html;
    }

    /**
     * Renderiza el contenido del elemento del menú.
     * @param array $item
     * @return string
     */
    protected function renderItem(array $item): string
    {
        if (!isset($item['headline'])) {
            throw new \yii\base\InvalidConfigException("El atributo 'headline' es requerido para el item del menú.");
        }

        if (!isset($item['options'])) {
            $item['options'] = [];
        }

        $leading = isset($item['leading']) ? Html::tag('md-icon', $item['leading'], ['slot' => 'start']) . "\n" : '';
        $trailing = isset($item['trailing']) ? Html::tag('md-icon', $item['trailing'], ['slot' => 'end']) . "\n" : '';
        $url = ArrayHelper::getValue($item['options'], 'href', false);

        if ($url !== false) {
            $item['options']['href'] = Url::to($url);
        }

        $html = Html::beginTag('md-menu-item', $item['options']) . "\n";
        if (isset($item['options']['type']) && $item['options']['type'] == 'divider') {
            $html .= Html::tag('md-divider', '', $item['options']);
        } else {
            $html .= $leading;
            $html .= Html::tag('div', $item['headline'], ['slot' => 'headline']) . "\n";
            $html .= $trailing;
        }

        $html .= Html::endTag('md-menu-item') . "\n";

        return $html;
    }
}