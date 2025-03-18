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
use neoacevedo\yii2\material\Html;

/**
 * Lists se encarga de renderizar el componente List de Material Web.
 * 
 * Se pluraliza el nombre dado que PHP posee un nombre de función igual y el lenguaje en esto no distingue entre mayúsculas y minúsculas.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://material-web.dev/components/list/
 * @see https://m3.material.io/components/lists/overview
 */
class Lists extends Widget
{
    const ITEM_TYPE_BUTTON = 'button';
    const ITEM_TYPE_LINK = 'link';

    /**
     * @var array The data to be displayed in the list.
     * Each item can be a single text or html, or an array with the following structure:
     * - overline: string, optional, the overline text.
     * - headline: string, the main content. Maybe a single text or HTML content.
     * - supporting-text: string, optional, the secondary text.
     * - trailing-supprting-text: string, optional, a secondary text at the end of the supporting text.
     * - icon: string, the icon to display.
     * - options: array, the key value pair for additional configuration options.
     * @see https://material-web.dev/components/list/#properties-1
     */
    public $items = [];

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @inheritDoc 
     */
    public function run(): void
    {
        $this->initOptions();
        echo Html::list(items: $this->items, options: $this->options);
    }

    /**
     * @inheritDoc
     */
    protected function initOptions(): void
    {
        $this->options = array_merge([
            'id' => $this->id,
        ], $this->options);

    }
}
