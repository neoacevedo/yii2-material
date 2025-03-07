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
use yii\helpers\ArrayHelper;


class Dialog extends Widget
{

    public ?string $icon;

    /**
     * Estas son las series de botones de acción que contiene el componente.
     * @see https://m3.material.io/components/dialogs/guidelines#befd7f4d-1029-4957-b1b5-da13fc0bbf3c
     * @var array
     */
    public array $buttons = [];

    public array $bodyOptions = [];

    public array $closeButton = [];

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
     * The following special options are recognized:
     *
     * - `quick`: boolean as string, "true" or "false". Skips the opening and closing animations.
     * - `no-focus-trap`: boolean as string, "true" or "false". Disables focus trapping, which by default keeps keyboard Tab navigation within the dialog. 
     *      When disabled, after focusing the last element of a dialog, pressing Tab again will release focus from the window back to the browser (such as the URL bar). 
     *      Focus trapping is recommended for accessibility, and should not typically be disabled. Only turn this off if the use case of a dialog is more accessible without focus trapping.
     * - `type`: The type of dialog for accessibility. Set this to `alert` to announce a dialog as an alert dialog.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @see https://material-web.dev/components/dialog/#properties for more dialog properties.
     */
    public array $options = [];

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

        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        $html = Html::beginTag('md-dialog', $this->options) . "\n";

        if ($this->icon) {
            $html .= "<md-icon slot=\"icon\">{$this->icon}</md-icon>\n";
        }

        $html .= $this->renderHeader() . "\n";

        $html .= $this->renderBodyBegin() . "\n";
        $html .= ob_get_clean();
        $html .= $this->renderBodyEnd(); // End body
        $html .= $this->renderButtons() . "\n";

        $html .= Html::endTag('md-dialog'); // End dialog

        return $html;
    }

    protected function renderButtons(): string|null
    {
        $content = '';

        if (isset($this->buttons)) {
            $content .= implode("\n", $this->buttons);
            return Html::tag('div', $content, options: ['slot' => 'actions']);
        }

        return null;

    }

    /**
     * Renderiza el inicio de la etiqueta del cuerpo del diálogo.
     * @return string
     */
    protected function renderBodyBegin(): string
    {
        return Html::beginTag('form', array_merge(['slot' => 'content', 'method' => 'dialog'], $this->bodyOptions));
    }

    /**
     * Renderiza el cierre de la etiqueta del cuerpo del diálogo.
     * @return string
     */
    protected function renderBodyEnd(): string
    {
        return Html::endTag('form');
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