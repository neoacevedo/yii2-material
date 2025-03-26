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

/**
 * TopAppBar se encarga de renderizar el componente TopAppBar de Material 3.
 * 
 * Dado que Material 3 no dispone del componente en web, se crea uno desde 0.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 */
class TopAppBar extends Widget
{
    /**
     * Este es el título que puede ser el de la página visitada o el nombre de la aplicación
     * @var string
     */
    public $headline = '';
    /**
     * Icono principal.
     * @var mixed
     */
    public $leadingIcon; // Icono principal (a la izquierda)

    /**
     * Iconos finales.
     * @var array
     */
    public $trailingIcons = []; // Array de iconos finales (a la derecha)

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    public $leadingIconClickEvent = 'leading-icon-click';

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        if ($this->headline === null) {
            $this->headline = Yii::$app->name; // Título por defecto
        }

        $this->initOptions();
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        echo Html::beginTag(name: 'md-top-app-bar', options: $this->options) . "\n";
        // Icono principal (si se proporciona)
        if ($this->leadingIcon !== null) {
            echo Html::beginTag('div', ['slot' => 'leading-icon']) . "\n";
            echo Html::iconButton(options: ['icon' => $this->leadingIcon]) . "\n";
            echo Html::endTag('div') . "\n";
        }

        echo Html::tag('span', Html::encode($this->headline), ['slot' => 'headline', 'class' => 'app-title']);

        if (count($this->trailingIcons) > 0) {
            echo Html::beginTag('div', ['slot' => 'trailing-icon']) . "\n";

            foreach ($this->trailingIcons as $icon) {
                echo Html::iconButton(options: array_merge(['icon' => $icon['icon'], 'href' => $icon['url']], $icon['options'])) . "\n";
            }
            echo Html::endTag('div') . "\n";
        }

        echo Html::endTag('md-top-app-bar');
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     * @return void
     */
    protected function initOptions(): void
    {
        $this->options = array_merge([
            'id' => $this->getId(),
            'class' => 'small'
        ], $this->options);
    }
}
