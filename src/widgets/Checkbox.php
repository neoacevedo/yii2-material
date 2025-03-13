<?php

/**
 * @copyright Copyright (c) 2025 neoacevedo
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
 * Checkbox se encarga de renderizar el componente Checkbox de Material Web.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://material-web.dev/components/checkbox/
 * @see https://m3.material.io/components/checkbox/overview
 */
class Checkbox extends Widget
{
    /**
     * The name attribute
     * @var string
     */
    public string $name = '';

    /**
     * Whether the checkbox should be checked.
     * @var bool
     */
    public bool $checked = false;

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * @see \yii\helpers\Html::booleanInput() for details about accepted attributes.
     */
    public array $options = [];

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        $this->options = array_merge([
            'id' => $this->id
        ], $this->options);

        echo Html::checkbox(name: $this->name, checked: $this->checked, options: $this->options);
    }
}