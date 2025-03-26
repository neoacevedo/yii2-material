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
    public $items = [];
    public $options = []; // Opciones para el contenedor del menú (<ul>)

    public function init()
    {
        parent::init();

        // Asegura que los items tengan la estructura correcta
        foreach ($this->items as &$item) {
            if (!isset($item['headline'])) {
                throw new \yii\base\InvalidConfigException("El atributo 'headline' es requerido para cada item del menú.");
            }

            if (!isset($item['options'])) {
                $item['options'] = [];
            }
        }
        unset($item); // Limpia la referencia
    }

    public function run()
    {
        if (empty($this->items)) {
            return ''; // No renderizar nada si no hay items
        }

        $options = ArrayHelper::merge(['id' => $this->id], $this->options); // Clase base de Material
        echo Html::beginTag('md-menu', $options);

        foreach ($this->items as $item) {
            $this->renderItem($item) . "\n";
        }

        echo Html::endTag('md-menu');
    }

    protected function renderItem(&$item)
    {
        $icon = ArrayHelper::remove($item['options'], 'icon', false);
        $url = ArrayHelper::getValue($item['options'], 'href', false);

        if ($url !== false) {
            $item['options']['href'] = Url::to($url);
        }

        echo Html::beginTag('md-menu-item', $item['options']);
        echo Html::tag('div', $item['headline'], ['slot' => 'headline']);
        if ($icon !== false) {
            echo Html::tag('md-icon', $icon, ['slot' => 'end']);
        }
        echo Html::endTag('md-menu-item');
    }
}