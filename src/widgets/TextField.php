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

use yii\base\InvalidConfigException;

use neoacevedo\yii2\material3\Html;
use yii\widgets\InputWidget;

/**
 * TextField es la clase que renderiza los campos tipo text, password o textarea. Cualquier otro tipo generará un error de configuración.
 * 
 * Para generar un textarea, basta con definir dentro de [[options]] la propiedad `type` a `textarea`.
 * 
 * Las clases que se extienden desde este widget se pueden utilizar en un [[\yii\widgets\ActiveForm|ActiveForm]] usando el método [[\yii\widgets\ActiveField::widget()|widget()]],
 * por ejemplo:
 * 
 * ```php
 * <?= $form->field($model, 'description')->widget('WidgetClassName', [
 *    'options' => [
 *         'type' => 'textarea', // password, text.
 *        // configure additional widget properties here
 *    ]
 * ]) ?>
 * ```
 * 
 * @see [[\yii\widgets::InputWidget()]] para más detalles
 */
class TextField extends InputWidget
{
    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_PASSWORD = 'password';
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();

        $this->options = array_merge([
            'type' => self::TYPE_TEXT
        ], $this->options);

        if (!in_array($this->options['type'], ['text', 'textarea', 'password'])) {
            throw new InvalidConfigException(message: "Either 'type' property must be set to 'text', 'password' or 'textearea'.");
        }

    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        return $this->renderInputHtml('text');
    }

    /**
     * Render a HTML input tag.
     *
     * This will call [[Html::activeInput()]] if the input widget is [[hasModel()|tied to a model]],
     * or [[Html::input()]] if not.
     *
     * @return string the HTML of the input field.
     * @see Html::activeInput()
     * @see Html::input()
     */
    protected function renderInputHtml($type): string
    {
        if ($this->hasModel()) {
            return Html::activeInput(type: $type, model: $this->model, attribute: $this->attribute, options: $this->options);
        }
        return Html::input(type: $type, name: $this->name, value: $this->value, options: $this->options);
    }
}