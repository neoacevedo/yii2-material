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

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class Menu extends Widget
{
    public $items = [];
    public $options = []; // Opciones para el contenedor del menú (<ul>)
    public $itemOptions = []; // Opciones para cada ítem del menú (<li>)
    public $linkOptions = []; // Opciones para los enlaces (<a>)

    public function init()
    {
        parent::init();

        // Asegura que los items tengan la estructura correcta
        foreach ($this->items as &$item) {
            if (!isset($item['label'])) {
                throw new \yii\base\InvalidConfigException("El atributo 'label' es requerido para cada item del menú.");
            }
            if (!isset($item['url'])) {
                $item['url'] = '#'; // URL por defecto
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

    protected function renderItem($item)
    {
        echo Html::beginTag('md-menu-item', $this->itemOptions);
        echo Html::beginTag('div', ['slot' => 'headline']);
        echo Html::a($item['label'], $item['url'], $this->linkOptions);
        echo Html::endTag('div');
        echo Html::endTag('md-menu-item');
    }
}