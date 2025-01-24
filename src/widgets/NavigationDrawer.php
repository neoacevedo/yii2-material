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
use yii\helpers\Url;

/**
 * NavigationDrawer renderiza
 */
class NavigationDrawer extends Widget
{

    const DRAWER_MODAL = 'modal';
    const DRAWER_BOTTOM = 'bottom';
    const DRAWER_DISMISSIBLE = 'dismissible';

    public string $variant = '';

    /**
     * Lista de los elementos del Navigation Drawer. Cada elemento debe ser un array con la siguiente estructura:
     * - content: string, un texto o el contenido HTML del elemento. Si [[encode]] es true, el contenido será codificado en HTML.
     * - options: array, opcional, 
     * - overline: string, opcional, texto de encabezado para cada elemento.
     * - supporting-text: string, opcional, texto secundario.
     * - trailing-supporting-text: string, opcional
     * 
     * @var array
     */
    public array $items = [];

    public array $options = [];

    public function init(): void
    {
        parent::init();
        $view = $this->getView();
        $view->registerJs(<<<JS
            const navigationDrawer = new mdc.drawer.MDCDrawer(document.querySelector('.mdc-drawer'));
JS, \yii\web\View::POS_END);
    }

    public function run(): void
    {
        $variant = '';
        $variant = $this->variant ? "mdc-drawer--{$this->variant}" : "mdc-drawer--dismissible mdc-drawer--open";

        Html::addCssClass($this->options, ['widget' => "mdc-drawer $variant"]);

        echo Html::beginTag("aside", $this->options) . "\n";
        echo Html::beginTag("div", ['class' => 'mdc-drawer__content']) . "\n";
        if (!empty($this->items)) {
            echo $this->renderItems($this->items);
        }
        echo Html::endTag("aside") . "\n";
        if ($this->variant) {
            echo Html::tag("div", '', ['class' => 'mdc-drawer-scrim']) . "\n";
        }
    }

    /**
     * SRenderiza los elementos del menú.
     * @param array $items
     * @return string
     */
    protected function renderItems(array $items): string
    {
        return Lists::widget([
            'items' => $items
        ]);
    }
}