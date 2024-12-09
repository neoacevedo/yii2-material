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
use yii\helpers\ArrayHelper;


class Dialog extends Widget
{
    /**
     * Estas son las series de botones de acción que contiene el componente.
     * @see https://github.com/material-components/material-components-web/tree/master/packages/mdc-card#actions
     * @var array
     */
    public array $actions = [];

    public array $bodyOptions = [];

    public array $closeButton = [];

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
     * The following special options are recognized:
     *
     * - `quick`: the tag name of the container element. Defaults to `div`. Setting it to `false` will not render a container tag.
     * - `no-focus-trap`: Disables focus trapping, which by default keeps keyboard Tab navigation within the dialog.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @see https://material-web.dev/components/dialog/#properties for dialog properties.
     */
    public array $dialogOptions = [];

    /**
     * @var array additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions = [];

    /**
     * @var string the title content in the dialog window.
     */
    public string $title;

    /**
     * @var array additional title options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $titleOptions = [];

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->initOptions();

        echo Html::beginTag('md-dialog', $this->dialogOptions) . "\n";
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";
        echo $this->renderActionButtons() . "\n";
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        echo "\n" . Html::endTag('form'); // End body
        echo "\n" . Html::endTag('md-dialog'); // End dialog
    }

    protected function renderActionButtons(): string|null
    {
        $content = '';

        if (isset($this->actions['buttons'])) {
            $content .= implode("\n", $this->actions['buttons']);
            return Html::tag('div', $content, options: ['slot' => 'actions']);
        }

        return null;

    }

    /**
     * Renders the opening tag of the dialog body.
     * @return string
     */
    protected function renderBodyBegin(): string
    {
        return Html::beginTag('form', array_merge(['slot' => 'content', 'method' => 'dialog'], $this->bodyOptions));
    }

    protected function renderCloseButton(): string
    {
        if (($closeButton = $this->closeButton) !== false) {
            $options = array_merge([
                'form' => ArrayHelper::getValue($this->bodyOptions, 'id', 'form'),
                'data-aria-label' => 'Close dialog'
            ], $closeButton);
            return Html::tag('md-icon-button', "<md-icon>close</md-icon>\n", $options);
        }

        return null;

    }

    /**
     * Renders the header HTML markup of the dialog
     * @return string
     */
    protected function renderHeader(): string
    {
        $this->headerOptions = array_merge([
            'slot' => 'headline'
        ], $this->headerOptions);

        $closeButton = $this->renderCloseButton();

        if (isset($this->title)) {
            $header = (count($this->actions) > 0) ? Html::tag('span', $this->title)
                : Html::tag('h5', $this->title, ['style' => 'flex: 1;']);
        }

        if ($closeButton !== null) {
            $header .= "\n$closeButton";
        } elseif ($header === '') {
            return '';
        }

        return Html::tag('div', "\n$header\n", $this->headerOptions);
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions(): void
    {
        $this->dialogOptions = array_merge([
            'id' => $this->getId()
        ], $this->dialogOptions);

        $this->bodyOptions = array_merge(['slot' => 'content', 'id' => 'form'], $this->bodyOptions);
    }

}