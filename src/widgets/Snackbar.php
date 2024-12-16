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

class Snackbar extends Widget
{
    const TYPE_LEADING = 'leading';
    const TYPE_STACKED = 'stacked';

    /**
     * Estas son las series de botones de acción que contiene el componente.
     * @see https://github.com/material-components/material-components-web/tree/master/packages/mdc-card#actions
     * @var array
     */
    public array $actions = [];

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
     * The following special options are recognized:
     *
     * - `variant`: the tag name of the container element. Defaults to `div`. Setting it to `false` will not render a container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @see https://material-web.dev/components/dialog/#properties for dialog properties.
     */
    public array $options = [];

    public string $label;

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        $this->initOptions();

        $html = Html::beginTag('aside', $this->options) . "\n";
        $html .= Html::beginTag('div', ['class' => 'mdc-snackbar__surface', 'role' => 'status', 'aria-relevants' => 'additions']) . "\n";
        $html .= Html::beginTag('div', ['class' => 'mdc-snackbar__label', 'aria-atomic' => false]);
        $html .= $this->label . "\n";
        $html .= Html::endTag('div') . "\n"; // Fin div label
        $html .= $this->renderActionButtons();
        $html .= Html::endTag('div') . "\n"; // Fin div surface
        $html .= Html::endTag('aside') . "\n";

        echo $html;
    }

    protected function initOptions(): void
    {
        $variant = isset($this->options['variant']) ? "mdc-snackbar--" . $this->options['variant'] : '';
        $this->options = array_merge([
            'id' => $this->id,
            'class' => $variant
        ], $this->options);

        Html::addCssClass($this->options, ['widget' => 'mdc-snackbar']);
    }

    protected function renderActionButtons(): string|null
    {
        if (count($this->actions) == 0) {
            return null;
        }
        $content = implode("\n", $this->actions);
        return Html::tag('div', $content, options: ['class' => 'mdck-snackbar__actions']);
    }
}