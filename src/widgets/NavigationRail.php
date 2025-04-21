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

/**
 * NavigationRail renderiza elementos en una barra lateral.
 * 
 * Un ejemplo de uso de este widget seria de este modo:
 * 
 * ```php
 * <?= NavigationRail::widget([
 *    'options' => [
 *      'class' => 'align-bottom, // Define la alineación de los elementos
 *    ]
 *   'items' => [
 *       FloatingActionButton::widget(
 *           config: [
 *               'icon' => 'dark_mode',
 *               'options' => [
 *                   'lowered' => true,
 *                   'class' => 'nav-item'
 *               ],
 *           ]
 *       ),
 *      '<p style="pading-bottom: 0.5rem"></p>',
 *       [
 *           'icon' => 'group',
 *           'label' => 'Item 1',
 *           'options' => [
 *               'type' => 'link',
 *               'href' => ['#'],
 *           ]
 *       ],
 *       [
 *           'label' => 'Item 2',
 *           'options' => [
 *               'type' => 'link',
 *               'href' => ['#'],
 *           ]
 *       ],
 *       [
 *           'icon' => 'settings',
 *           'options' => [
 *               'type' => 'link',
 *               'href' => ['#'],
 *           ]
 *       ],
 *   ]
 * ]) ?>
 * ```
 * 
 * Para alinear los elementos de destino en el centro o abajo, se le asignan distintas clases CSS al componente web:
 * - align-center: clase CSS que alineará los elementos dentro del contenido en el centro.
 * - align-bottom: clase CSS que alineará los elementos dentro del contenido al fondo.
 * 
 * Dado que Material 3 no dispone del componente en web, se crea uno desde 0.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://m3.material.io/components/navigation-rail/guidelines
 */
class NavigationRail extends Widget
{

    /**
     * @var string|null Este es el contenido que se mostrará como primer elemento del [[NavigationRail]]. 
     * Puede ser un [[IonButton]], un [[FloatingActionButton]] o un texto.
     */
    public ?string $leading = null;

    /**
     * @var string|null Este es el contenido que se mostrará como último elemento del [[NavigationRail]]. 
     * Puede ser un [[IonButton]], un [[FloatingActionButton]] o un texto.
     */
    public ?string $trailing = null;

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
     * Lista de los elementos del Navigation Rail. Cada elemento puede ser un array con la siguiente estructura:
     * - url: string|array, la dirección URL de destino.
     * - options: array, opcional, 
     * - icon: string, el ícono del elemento.
     * - label: string, la etiqueta del elemento.
     * 
     * El elemento puede ser también un string HTML que contenga un [[FloatingActionButton]].
     * @see https://m3.material.io/components/navigation-rail/guidelines#b51e4558-351f-4368-af8d-bbf1f63f68b4
     * 
     * @var array
     */
    public array $items = [];

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
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
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }

        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }

        echo Html::beginTag(name: 'md-navigation-rail', options: $this->options) . "\n";
        if ($this->leading) {
            echo Html::tag(name: 'div', content: $this->leading, options: ['slot' => 'leading', 'class' => 'leading']) . "\n";
        }

        echo Html::beginTag(name: 'div', options: ['class' => 'navigation-rail-content', 'slot' => 'content']) . "\n";
        $this->renderItems();

        if ($this->trailing) {
            echo Html::tag(name: 'div', content: $this->trailing, options: ['slot' => 'trailing', 'class' => 'nav-item']) . "\n";
        }
        echo Html::endTag(name: 'div') . "\n";

        echo Html::endTag(name: 'md-navigation-rail') . "\n";
    }

    /**
     * Renderiza los elementos del Navigation Rail.
     * @return void
     * @throws \yii\base\InvalidConfigException
     */
    protected function renderItems(): void
    {
        foreach ($this->items as &$item) {
            if (is_array($item)) {
                if (!isset($item['icon'])) {
                    throw new \yii\base\InvalidConfigException("El atributo 'icon' es requerido para cada item del menú.");
                }

                $options = array_merge(['class' => 'nav-item'], $item['options']);

                if (isset($item['visible']) && !$item['visible']) {
                    unset($item);
                    continue;
                }

                if (!isset($options['href'])) {
                    $options['href'] = '#'; // URL por defecto
                }

                if (!isset($item['active'])) {
                    if ($this->activateItems && $this->isItemActive($item)) {
                        $options['class'] .= ' active';
                    } else {
                        $options['active'] = false;
                    }
                } elseif ($item['active'] instanceof Closure) {
                    if (call_user_func($item['active'], $item, $this->isItemActive($item), $this)) {
                        $options['class'] .= ' active';
                    } else {
                        $item['active'] = false;
                    }
                }

                $itemContent = Html::tag(name: 'div', content: "<md-ripple></md-ripple>\n<md-icon>{$item['icon']}</md-icon>", options: ['class' => 'icon']);
                $itemContent .= Html::tag(name: 'span', content: $item['label'], options: ['class' => 'label']);
                echo Html::a(text: $itemContent, url: $options['href'], options: $options);
            } else {
                echo $item;
            }
        }
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