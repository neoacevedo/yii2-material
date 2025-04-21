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

use Closure;
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

    const DRAWER_STANDARD = 'standard';

    /**
     * @var string|null La urta usada para determinar si un elemento del navigation esá activo o no. Si no se configura, usará la ruta 
     * de la solicitud actual.
     */
    public ?string $route = null;

    /**
     * @var array|null the parameters used to determine if a menu item is active or not.
     * If not set, it will use `$_GET`.
     * @see route
     * @see isItemActive()
     */
    public ?array $params = null;

    /**
     * @var bool whether to automatically activate items according to whether their route setting
     * matches the currently requested route.
     * @see isItemActive()
     */
    public $activateItems = true;

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
     * - type: string, [[self::DRAWER_MODAL]] or [[self::DRAWER_STANDARD]].
     * 
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $options = [];

    public function init(): void
    {
        $this->options = array_merge([
            'id' => $this->getId(),
            'type' => self::DRAWER_STANDARD,
        ], $this->options);

    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }

        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }

        echo Html::beginTag(name: 'md-navigation-drawer', options: $this->options) . "\n";

        echo Html::beginTag(name: 'div', options: ['class' => 'navigation-drawer-content', 'slot' => 'content']) . "\n";
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
        $items = $this->items;
        foreach ($items as $i => $item) {
            if (is_array($item)) {
                if (!isset($item['options']['class'])) {
                    $items[$i]['options']['class'] = 'drawer-list-item';
                }
                if (!isset($item['options']['selected'])) {
                    if ($this->activateItems && $this->isItemActive($item)) {
                        $items[$i]['options']['selected'] = 'selected';
                    } else {
                        unset($items[$i]['options']['selected']);
                    }
                } elseif ($item['options']['selected'] instanceof Closure) {
                    if (call_user_func($item['options']['selected'], $item, $this->isItemActive($item), $this)) {
                        $items[$i]['options']['selected'] = 'selected';
                    } else {
                        unset($items[$i]['options']['selected']);
                    }
                }
            }
        }

        echo Html::list(items: $items, options: $this->options);
    }

    /**
     * Checks whether a menu item is active.
     * 
     * This is done by checking if $route and $params match that specified in the url option of the menu item. 
     * When the url option of a menu item is specified in terms of an array, its first element is treated as the route for the item and the rest of the elements are the associated parameters. Only when its route and parameters match $route and $params, respectively, will a menu item be considered active.
     * @param array $item The menu item to be checked
     * @return bool
     */
    protected function isItemActive($item)
    {
        if (isset($item['options']['href']) && is_array($item['options']['href']) && isset($item['options']['href'][0])) {
            $route = Yii::getAlias($item['options']['href'][0]);
            if (strncmp($route, '/', 1) !== 0 && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }

            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['options']['href']['#']);
            if (count($item['options']['href']) > 1) {
                $params = $item['options']['href'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}