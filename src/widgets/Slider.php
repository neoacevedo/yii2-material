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

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Slider se encarga de renderizar el componente Slider de Material Web.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://material-web.dev/components/slider/
 */
class Slider extends Widget
{

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
     * The following special options are recognized:
     *
     * - `ticks`: Whether or not to show tick marks..
     * - `value`: numeric. The slider value displayed when range is false.
     * - `type`: The type of dialog for accessibility. Set this to `alert` to announce a dialog as an alert dialog.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @see https://material-web.dev/components/slider/#properties for more slider properties.
     */
    public array $options = [];

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        echo Html::tag('md-slider', "", array_merge(['id' => $this->id], $this->options));
    }

}