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
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * IconButton se encarga de renderizar el componente IconButton de Material Web.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://material-web.dev/components/icon-buttons/
 * @see https://m3.material.io/components/icon-buttons/overview
 */
class IconButton extends Widget
{
    const TYPE_OUTLINED = 'outlined';

    const TYPE_FILLED = 'filled';

    const TYPE_FILLED_TONAL = 'filled-tonal';

    const TYPE_STANDARD = 'standard';

    public string $icon = '';

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
     * The following special options are recognized:
     *
     * - `variant`: string, the button variant.
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
            'icon' => $this->icon,
            'variant' => self::TYPE_STANDARD
        ], $this->options);
        \Yii::debug($this->options);
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return Html::iconButton(options: $this->options);
    }
}