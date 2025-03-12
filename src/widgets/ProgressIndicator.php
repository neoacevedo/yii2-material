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
 * ProgressIndicator renderiza el componente web progress de Material Web.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://material-web.dev/components/progress/
 */
class ProgressIndicator extends Widget
{
    const MD_PROGRESS_TYPE_CIRCULAR = 'circular';
    const MD_PROGRESS_TYPE_LINEAR = 'linear';

    /**
     * El tipo de progess indicator a renderizar.
     * @var string
     */
    public string $type = '';

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
    public function run(): void
    {
        $this->options = array_merge([
            'id' => $this->id
        ], $this->options);

        echo Html::tag(name: "md-{$this->type}-progress", content: '', options: $this->options);
    }
}