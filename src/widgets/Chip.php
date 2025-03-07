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
 * Chip se encarga de renderizar el componente Chip de Material Web.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://material-web.dev/components/chip/
 * @see https://m3.material.io/components/chips/overview
 */
class Chip extends Widget
{
    const TYPE_ASSIST = 'assist';

    const TYPE_FILTER = 'filter';

    const TYPE_INPUT = 'input';

    const TYPE_SUGGESTION = 'suggestion';

    /**
     * @var array los chips que se van a renderizar.
     */
    public $chips = [];

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return Html::tag('md-chip-set', $this->renderChips());
    }

    /**
     * Renderiza la etiqueta HTML de los chips.
     * @return string
     */
    protected function renderChips(): string
    {
        $content = '';
        foreach ($this->chips as $chip) {
            $type = $chip['type'];

            if (!isset($chip['options']['has-icon'])) {
                $chip['options']['has-icon'] = false;
            } else {
                if (filter_var($chip['options']['icon'], FILTER_VALIDATE_URL | FILTER_VALIDATE_EMAIL)) {
                    $content .= Html::img($chip['options']['icon']);
                }
            }

            if (!isset($chip['options']['has-selected-icon'])) {
                $chip['options']['has-icon'] = false;
            } else {
                $content .= Html::tag('md-icon', $chip['options']['selected-icon'], ['slot' => 'icon']);
            }

            unset($chip['options']['type'], $chip['options']['selected-icon']);

            $content .= Html::tag("md-$type-chip", $content, $chip['options']) . "\n";
        }

        return $content;
    }
}