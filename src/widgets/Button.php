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
use yii\base\Widget;

/**
 * Button renderiza el componente Button de Material.
 * 
 * Ejemplo: 
 * ```php
 * echo Button::widget([
 *     'label' => 'Action',
 *     'options' => [
 *          'icon' => 'send',
 *          'variant' => Button::TYPE_FILLED, // si no se especifica, por defecto será 'outlined'
 *          'trailing-icon' => false, // true si el ícono va a la derecha del label.
 *      ],
 * ]);
 * ```
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 */
class Button extends Widget
{

    const TYPE_OUTLINED = 'outlined';

    const TYPE_FILLED = 'filled';

    const TYPE_TONAL = 'filled-tonal';

    const TYPE_ELEVATED = 'elevated';

    const TYPE_TEXT = 'text';

    /**
     * Texto del botón
     * @var string
     */
    public string $label = 'Button';

    /**
     * Si [[$label]] tiene caracteres especiales, estos son codificados en entidades HTML.
     * @var bool
     */
    public bool $encodeLabel = true;

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $options = [];

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();
        $this->options = array_merge([
            'id' => $this->id,
            'type' => 'button'
        ], $this->options);
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return Html::button(content: $this->encodeLabel ? Html::encode($this->label) : $this->label, options: $this->options);
    }
}
