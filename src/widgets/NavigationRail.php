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

class NavigationRail extends Widget
{
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
        echo Html::beginTag(name: 'md-navigation-rail', options: $this->options) . "\n";
        echo Html::beginTag(name: 'div', options: ['class' => 'navigation-rail-content']) . "\n";
        $this->renderItems();
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
                if (!isset($item['label'])) {
                    throw new \yii\base\InvalidConfigException("El atributo 'label' es requerido para cada item del menú.");
                }

                if (!isset($item['url'])) {
                    $item['url'] = '#'; // URL por defecto
                }
                if (!isset($item['options'])) {
                    $item['options'] = [];
                }

                $itemContent = Html::tag(name: 'div', content: "<md-ripple></md-ripple>\n<md-icon>{$item['icon']}</md-icon>", options: ['class' => 'icon']);
                $itemContent .= Html::tag(name: 'span', content: $item['label'], options: ['class' => 'label']);
                echo Html::a(text: $itemContent, url: $item['url'], options: array_merge(['class' => 'nav-item'], $item['options']));
            } else {
                echo $item;
            }
        }
    }
}