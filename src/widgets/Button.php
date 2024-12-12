<?php

/**
 * @copyright Copyright (c) 2024 neoacevedo
 * @subpackage yii2-material3
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

namespace neoacevedo\yii2\material3\widgets;

use neoacevedo\yii2\material3\Html;
use yii\base\Widget;

/**
 * Button renderiza el componente Button de Material.
 * 
 * Ejemplo: 
 * ```php
 * echo Button::widget([
 *     'label' => 'Action',
 *     'type' => Button::TYPE_FILLED, // si no se especifica, por defecto será 'outlined'
 *     'options' => [
 *          'icon' => 'send',
 *          'trailing-icon' => false, // true si el ícono va a la derecha del label.
 *      ],
 * ]);
 * ```
 */
class Button extends Widget
{

    const TYPE_OUTLINED = 'outlined';

    const TYPE_FILLED = 'filled';

    const TYPE_TONAL = 'tonal';

    const TYPE_ELEVATED = 'elevated';

    const TYPE_TEXT = 'text';

    public string $label = 'Button';

    public bool $encodeLabel = true;

    public array $options = [];

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();
        $this->options = array_merge([
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