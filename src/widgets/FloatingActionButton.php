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

use yii\base\Widget;
use yii\helpers\Html;

/**
 * FloatingActionButton renderiza los botones de acción flotantes de Material 3.
 * 
 * El botón hará uso de [[$icon]] o [[$label]] para determinar el contenido por defecto.
 * Si ninguno de estos atributos es establecido, generará un [[\yii\base\InvalidConfigException]].
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://material-web.dev/components/fab/
 */
class FloatingActionButton extends Widget
{
    /**
     * (Opcional) Texto que tendrá el botón para describir su acción. 
     * Si no se establece un ícono, este será el contenido por defecto del botón.
     * @var string|null
     */
    public ?string $label = null;

    /**
     * (Opcional) Ícono que tendrá el botón. 
     * Si no se establece este atributo, se usará [[$label]] como contenido por defecto del botón.
     * @var string|null
     */
    public ?string $icon = null;


    /**
     * Atributos HTML para el FAB. 
     * Los atributos HTML pueden ser cualquier atributo conocido de etiquetas HTML.
     * Las siguientes opciones especiales son reconocidas:
     * - [lowered](https://material-web.dev/components/fab/#lowered): booleano, indicando si el botón tendrá una elevación baja. 
     * - [size](https://material-web.dev/components/fab/#sizes): string, determina el tamaño del botón. 
     * 
     * @var array
     */
    public array $options = [];

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        if (!isset($this->icon) && !isset($this->label)) {
            throw new \yii\base\InvalidConfigException("El atributo 'icon' es requerido.");
        }

        $this->options = array_merge([
            'id' => $this->id,
            'label' => $this->label
        ], $this->options);

    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        $html = Html::beginTag(name: 'md-fab', options: $this->options);
        $html .= Html::tag(name: 'md-icon', content: $this->icon, options: ['slot' => 'icon']);
        $html .= Html::endTag(name: 'md-fab');

        return $html;
    }
}