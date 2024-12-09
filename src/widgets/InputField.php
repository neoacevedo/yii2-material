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
use yii\base\Widget;

use neoacevedo\yii2\material3\Html;

/**
 * InputField es la clase para los widgets de texto que obtienen datos de usuario.
 * 
 * @see [[\yii\widgets::InputWidget()]] para más detalles
 */
class InputField extends Widget
{
    /**
     * @var \yii\widgets\ActiveField active input field, which triggers this widget rendering.
     * This field will be automatically filled up in case widget instance is created via [[\yii\widgets\ActiveField::widget()]].
     * @since 2.0.11
     */
    public $field;
    /**
     * @var \yii\base\Model|null the data model that this widget is associated with.
     */
    public $model;
    /**
     * @var string|null the model attribute that this widget is associated with.
     */
    public $attribute;
    /**
     * @var string|null the input name. This must be set if [[model]] and [[attribute]] are not set.
     */
    public $name;
    /**
     * @var string the input value.
     */
    public $value;
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
        if ($this->name === null && !$this->hasModel()) {
            throw new InvalidConfigException("Either 'name', or 'model' and 'attribute' properties must be specified.");
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        parent::init();
    }

    /**
     * @return bool whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }

    /**
     * Render a HTML input tag.
     *
     * This will call [[Html::activeInput()]] if the input widget is [[hasModel()|tied to a model]],
     * or [[Html::input()]] if not.
     *
     * @param string $type the type of the input to create.
     * @return string the HTML of the input field.
     * @see Html::activeInput()
     * @see Html::input()
     */
    protected function renderInputHtml($type)
    {
        if ($this->hasModel()) {
            return Html::activeInput($type, $this->model, $this->attribute, $this->options);
        }
        return Html::input($type, $this->name, $this->value, $this->options);
    }
}