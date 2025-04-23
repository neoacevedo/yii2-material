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

namespace neoacevedo\yii2\material;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

abstract class MaterialBaseHtml extends BaseHtml
{

    /**
     * Generates a checkbox tag together with a label for the given model attribute.
     * This method will generate the "checked" tag attribute according to the model attribute value.
     * @param \yii\base\Model $model the model object
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs.
     * See [[booleanInput()]] for details about accepted attributes.
     *
     * @return string the generated checkbox tag
     */
    public static function activeCheckbox($model, $attribute, $options = [])
    {
        return static::activeBooleanInput('checkbox', $model, $attribute, $options);
    }

    /**
     * @inheritDoc
     */
    public static function activeDropdownList($model, $attribute, $items, $options = [])
    {
        if (empty($options['multiple'])) {
            return static::activeListInput('dropDownList', $model, $attribute, $items, $options);
        }

        return static::activeListBox($model, $attribute, $items, $options);
    }

    /**
     * Generates an input tag for the given model attribute.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param string $type the input type (e.g. 'text', 'password')
     * @param \yii\base\Model $model the model object
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * 
     * @return string the generated input tag
     */
    public static function activeInput($type, $model, $attribute, $options = [])
    {
        $name = $options['name'] ?? static::getInputName($model, $attribute);
        $value = $options['value'] ?? static::getAttributeValue($model, $attribute);
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }

        if (!array_key_exists('label', $options)) {
            $options['label'] = $model->getAttributeLabel($attribute);
        }

        static::setActivePlaceholder($model, $attribute, $options);
        self::normalizeMaxLength($model, $attribute, $options);

        return static::input($type, $name, $value, $options);
    }

    /**
     * @inheritDoc
     */
    public static function activeListBox($model, $attribute, $items, $options = [])
    {
        return static::activeListInput('dropDownList', $model, $attribute, $items, $options);
    }

    /**
     * Generates a list of input fields.
     * This method is mainly called by [[activeListBox()]], [[activeRadioList()]] and [[activeCheckboxList()]].
     * @param string $type the input type. This can be 'listBox', 'radioList', or 'checkBoxList'.
     * @param \yii\base\Model $model the model object
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for the format
     * about attribute expression.
     * @param array $items the data item used to generate the input fields.
     * The array keys are the input values, and the array values are the corresponding labels.
     * @param array $options options (name => config) for the input list. The supported special options
     * depend on the input type specified by `$type`.
     * @return string the generated input list
     */
    protected static function activeListInput($type, $model, $attribute, $items, $options = [])
    {
        $name = ArrayHelper::remove($options, 'name', static::getInputName($model, $attribute));
        $selection = ArrayHelper::remove($options, 'value', static::getAttributeValue($model, $attribute));
        if (!array_key_exists('unselect', $options)) {
            $options['unselect'] = '';
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }

        return static::$type($name, $selection, $items, $options);
    }

    /**
     * @inheritDoc
     */
    public static function activePasswordInput($model, $attribute, $options = [])
    {
        return static::activeInput('text', $model, $attribute, $options);
    }

    /**
     * Generates a text input tag for the given model attribute.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param \yii\base\Model $model the model object
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * The following special options are recognized:
     *
     * - maxlength: integer|boolean, when `maxlength` is set true and the model attribute is validated
     *   by a string validator, the `maxlength` option will take the max value of [[\yii\validators\StringValidator::max]]
     *   and [[\yii\validators\StringValidator::length].
     *   This is available since version 2.0.3 and improved taking `length` into account since version 2.0.42.
     * - placeholder: string|boolean, when `placeholder` equals `true`, the attribute label from the $model will be used
     *   as a placeholder (this behavior is available since version 2.0.14).
     * - `filled`: int|bool, when it is se to `true` then the text input will be rendered as filled type. {@see https://m3.material.io/components/text-fields/overview#83ab732c-c40d-4470-8bc0-18e8d014acff}
     *
     * @return string the generated input tag
     */
    public static function activeTextInput($model, $attribute, $options = [])
    {
        return static::activeInput('text', $model, $attribute, $options);
    }

    /**
     * Genera un botón de ícono.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * 
     * The following special options are recognized:
     * - icon: string, the button's icon. See https://m3.material.io/components/icon-buttons/overview#a7ec0732-5bee-4b7e-9e64-333678d2b02b for icons.
     * - variant: string, the button variant used in Material 3.
     *   See https://m3.material.io/components/icon-buttons/specs#c2a5b845-c705-4bf3-83ad-6c99f25cb408 for variants.
     * 
     * @return string
     */
    public static function iconButton($options): string
    {
        $variant = $options['variant'] ?? 'standard';

        $content = "<md-icon>{$options['icon']}</md-icon>\n";

        unset($options['variant']);

        return static::tag($variant !== 'standard' ? "md-$variant-icon-button" : 'md-icon-button', $content, $options);
    }

    /**
     * Generates a button tag.
     * @param string $content the content enclosed within the button tag. It will NOT be HTML-encoded.
     * Therefore you can pass in HTML code such as an image tag. If this is is coming from end users,
     * you should consider [[encode()]] it to prevent XSS attacks.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * 
     * The following special options are recognized:
     * - variant: string, the button variant used in Material 3. To use combined variants, you may use, for instance, `filed-tonal`. 
     *   See [[https://m3.material.io/components/buttons/overview#501bf0cf-fbb5-45b5-abc1-c3bae35c0e6a]] for variants.
     * - icon: string, the icon at the left or right side of the label. To render the icon at the right side, `trailing-icon` must be set to `true`.
     * - trailing-icon: boolean, the icon ate the right side of the label.
     * 
     * @return string the generated button tag
     */
    public static function button($content = 'Button', $options = [])
    {
        if (!isset($options['type'])) {
            $options['variant'] = 'button';
        }

        $variant = $options['variant'] ?? 'outlined';

        $content .= isset($options['icon']) ? "\n<md-icon slot=\"icon\">{$options['icon']}</md-icon>\n" : '';

        unset($options['variant'], $options['icon']);

        return static::tag("md-$variant-button", $content, $options);
    }

    /**
     * @inheritDoc
     */
    public static function checkbox($name, $checked = false, $options = [])
    {
        // return static::tag(name: "md-checkbox", content: '', options: array_merge(['name' => $name, 'checked' => "$checked"], $options));
        return static::booleanInput("checkbox", $name, $checked, $options);
    }

    /**
     * Generates el componente web select.
     * @param mixed $name The input name
     * @param mixed $selection The selected value(s). String/boolean for single or array for multiple selection(s).
     * @param mixed $items The option data items. The array keys are option values, and the array values are the corresponding option labels. 
     *              The array can also be nested (i.e. some array values are arrays too). 
     *              For each sub-array, an option group will be generated whose label is the key associated with the sub-array. 
     *              If you have a list of data models, you may convert them into the format described above using [[\yii\helpers\ArrayHelper::map()]]. 
     *              Note, the values and labels will be automatically HTML-encoded by this method, and the blank spaces in the labels will also be HTML-encoded.
     * @param mixed $options The tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - options: array, the attributes for the select option tags. The array keys must be valid option values,
     *   and the array values are the extra attributes for the corresponding option tags. For example,
     *
     *   ```php
     *   [
     *       'value1' => ['disabled' => true],
     *       'value2' => ['label' => 'value 2'],
     *   ];
     *   ```
     * 
     * - encodeSpaces: bool, whether to encode spaces in option prompt and option value with `&nbsp;` character.
     *   Defaults to false.
     * - encode: bool, whether to encode option prompt and option value characters.
     *   Defaults to `true`. 
     * - strict: boolean, if `$selection` is an array and this value is true a strict comparison will be performed on `$items` keys. Defaults to false.
     *
     * The rest of the options will be rendered as the attributes of the resulting tag. The values will
     * be HTML-encoded using [[encode()]]. If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string
     */
    public static function dropDownList($name, mixed $selection = null, $items = [], $options = []): string
    {
        $options['name'] = $name;
        $type = $options['variant'] ?? 'outlined';
        unset($options['unselect'], $options['variant']);

        $selectOptions = static::renderDropdownListOptions(selection: $selection, items: $items, tagOptions: $options);
        return static::tag(name: "md-$type-select", content: "\n$selectOptions\n", options: $options);
    }

    /**
     * Genera el componente web Floating Action Button.
     * @param string $icon El ícono del botón.
     * @param bool $branded Si es true, el FAB se generará como un [`md-branded-fab`](https://material-web.dev/components/fab/#branded-fab).
     * @param array $options Atributos HTML para el FAB. 
     * Los atributos HTML pueden ser cualquier atributo conocido de etiquetas HTML.
     * Las siguientes opciones especiales son reconocidas:
     * 
     * - [lowered](https://material-web.dev/components/fab/#lowered): booleano, indicando si el botón tendrá una elevación baja. 
     * - [size](https://material-web.dev/components/fab/#sizes): string, determina el tamaño del botón. 
     * 
     * Si un valor es nulo, el atributo correspondiente no se entregará. 
     * Ver [[renderTagAttributes()] para obtener detalles sobre cómo se están representando los atributos.
     * @return string
     */
    public static function fab(string $icon, bool $branded = false, array $options = []): string
    {
        $html = $branded === false ? static::beginTag(name: 'md-fab', options: $options) : static::beginTag(name: 'md-branded-fab', options: $options);
        $html .= static::tag(name: 'md-icon', content: $icon, options: ['slot' => 'icon']);
        $html .= $branded === false ? static::endTag(name: 'md-fab') : static::endTag(name: 'md-branded-fab');

        return $html;
    }

    /**
     * Generates an input type of the given type.
     * @param string $type the type attribute.
     * @param string|null $name the name attribute. If it is null, the name attribute will not be generated.
     * @param string|null $value the value attribute. If it is null, the value attribute will not be generated.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated input tag
     */
    public static function input($type, $name = null, $value = null, $options = []): string
    {
        $content = '';
        $options['name'] = $name;
        $options['value'] = $value === null ? null : (string) $value;

        if (isset($options['leading-icon'])) {
            if (!is_array($options['leading-icon'])) {
                $content .= static::tag('md-icon', $options['leading-icon']);
            } else {
                $icon = ArrayHelper::remove($options['leading-icon'], 'icon', 'search');
                $content .= static::tag('md-icon-button', $icon, $options['leading-icon']);
            }
        }

        if (isset($options['trailing-icon'])) {
            if (!is_array($options['trailing-icon'])) {
                $content .= static::tag('md-icon', $options['trailing-icon']);
            } else {
                $icon = ArrayHelper::remove($options['trailing-icon'], 'icon', 'clear');
                $content .= static::tag('md-icon-button', $icon, $options['trailing-icon']);
            }
        }

        unset($options['leading-icon'], $options['trailing-icon']);

        if ($type === 'text') {
            $variant = $options['variant'] ?? 'outlined';

            unset($options['variant']);

            return static::tag("md-$variant-$type-field", $content, $options);
        }

        return static::tag("md-$type", $content, $options);
    }

    /**
     * Genera el componente web List.
     * @param array $items Los elementos de datos de la opción. La estructura del array de estos elementos puede ser como lo siguiente:
     * 
     *  ```php
     *      [
     *          'Opción 1',
     *          [
     *              'label' => '',
     *              'options' => [
     *                  'type' => 'divider'
     *              ]
     *          ],
     *          [
     *              'overline' => 'Overline Opción 2',
     *              'headline' => 'Opción 2',
     *              'supporting-text' => 'Lorem Ipsum',
     *              'trailing-supporting-text'
     *          ],
     *          [
     *              'overline' => 'Overline Opción 3',
     *              'leading-icon' => 'event',
     *              'headline' => 'Opción 3',
     *              'supporting-text' => 'Lorem Ipsum',
     *              'trailing-supporting-text',
     *              'trailing-icon' => 'star'
     *          ],
     *          [
     *              'headline' => 'Opción 4',
     *              'leading-icon' => 'star',
     *              'options' => [
     *                  'type' => 'button',
     *              ]
     *          ],
     *          [
     *              'headline' => 'Opción 5',
     *              'trailing-icon' => 'open_in_new',
     *              'options' => [
     *                  'type' => 'link',
     *                  'href' => 'https://google.com',
     *              ]
     *          ],
     *      ]
     *  ```
     * 
     * @param array $options las opciones de etiqueta en términos de pares de valor de nombre. Estos serán renderizado como 
     * los atributos de la etiqueta resultante. Las siguientes opciones son especialmente manejadas: 
     * 
     * - encodeSpaces: bool, si codificar espacios en la opción de valor de opción y opción con el carácter de &nbsp;. 
     *  Predeterminado en false.
     * - encode: bool, si codifica la opción caracteres de valor de opción y valor de opción.
     *  Predeterminado en true. 
     * - strict: boolean, si .$selection es un array y este valor es true, una comparación estricta se realizará en las claves de "$items". 
     *  Predeterminado en false. 
     * - visible: boolean, opcional, cuando el elemento de la lista sea visible.
     *
     * El resto de las opciones se representarán como los atributos de la etiqueta resultante. Los valores
     * serán codificados HTML usando [[self::encode()]]. Si un valor es nulo, el atributo correspondiente no se entregará.
     * Ver [[self::renderTagAttributes()] para obtener detalles sobre cómo se están representando los atributos.
     * @return string
     */
    public static function list(array $items = [], array $options = []): string
    {
        $listItems = static::renderListItems(items: $items, parentTagOptions: $options);
        return static::tag(name: "md-list", content: $listItems, options: $options);
    }

    /**
     * Genera el componente web md-radio.
     * @param string $name El nombre del campo.
     * @param bool $checked Indica si el campo está o no marcado.
     * @param array $options las opciones de etiqueta en términos de pares de valor de nombre. Estos serán renderizado como 
     * los atributos de la etiqueta resultante. Los valores serán codificados HTML usando [[self::encode()]]. 
     * Si un valor es nulo, el atributo correspondiente no se entregará.
     * Ver [[self::renderTagAttributes()] para obtener detalles sobre cómo se están representando los atributos.
     * @return string
     */
    public static function radio($name, $checked = false, $options = [])
    {
        // return static::tag(name: "md-radio", content: '', options: array_merge(['name' => $name, 'checked' => (string) $checked], $options));
        return static::booleanInput("radio", $name, $checked, $options);
    }

    /**
     * Genera el componente web md-switch.
     * @param string $name El nombre del campo.
     * @param bool $checked Indica si el campo está o no marcado.
     * @param array $options las opciones de etiqueta en términos de pares de valor de nombre. Estos serán renderizado como 
     * los atributos de la etiqueta resultante. Los valores serán codificados HTML usando [[self::encode()]]. 
     * Si un valor es nulo, el atributo correspondiente no se entregará.
     * Ver [[self::renderTagAttributes()] para obtener detalles sobre cómo se están representando los atributos.
     * @return string
     */
    public static function switch(string $name, bool $checked = false, array $options = [])
    {
        return static::booleanInput("switch", $name, $checked, $options);
    }

    /**
     * Generates a text area input.
     * @param string $name the input name
     * @param string $value the input value. Note that it will be encoded using [[encode()]].
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * The following special options are recognized:
     *
     * - `doubleEncode`: whether to double encode HTML entities in `$value`. If `false`, HTML entities in `$value` will not
     *   be further encoded. This option is available since version 2.0.11.
     *
     * @return string the generated text area tag
     */
    public static function textarea($name, $value = '', $options = [])
    {
        $options['name'] = $name;
        $options['type'] = 'textarea';
        $doubleEncode = ArrayHelper::remove($options, 'doubleEncode', true);
        $textType = 'outlined';
        if (isset($options['filled'])) {
            if ($options['filled'] === true) {
                $textType = 'filled';
            }
        }

        unset($options['filled']);

        return static::tag("md-$textType-text-field", static::encode($value, $doubleEncode), $options);
    }

    /**
     * Genera el componente web `slider`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string
     */
    public static function slider(array $options = []): string
    {
        return static::tag(name: 'md-slider', content: "", options: $options);
    }

    #region protected

    /**
     * Generates a boolean input
     * This method is mainly called by [[activeCheckbox()]] and [[activeRadio()]].
     * @param string $type the input type. This can be either `radio` or `checkbox`.
     * @param \yii\base\Model $model the model object
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs.
     * See [[booleanInput()]] for details about accepted attributes.
     * @return string the generated input element
     * @since 2.0.9
     */
    protected static function activeBooleanInput($type, $model, $attribute, $options = [])
    {
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        $value = static::getAttributeValue($model, $attribute);

        if (!array_key_exists('value', $options)) {
            $options['value'] = '1';
        }
        if (!array_key_exists('uncheck', $options)) {
            $options['uncheck'] = '0';
        } elseif ($options['uncheck'] === false) {
            unset($options['uncheck']);
        }
        if (!array_key_exists('label', $options)) {
            $options['label'] = static::encode($model->getAttributeLabel(static::getAttributeName($attribute)));
        } elseif ($options['label'] === false) {
            unset($options['label']);
        }

        $checked = "$value" === "{$options['value']}";

        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }

        return static::$type($name, $checked, $options);
    }

    /**
     * Generates a boolean input.
     * @param string $type the input type. This can be either `radio`, `checkbox` or `switch`.
     * @param string $name the name attribute.
     * @param bool $checked whether the checkbox should be checked.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - uncheck: string, the value associated with the uncheck state of the checkbox. When this attribute
     *   is present, a hidden input will be generated so that if the checkbox is not checked and is submitted,
     *   the value of this attribute will still be submitted to the server via the hidden input.
     * - label: string, a label displayed next to the checkbox.  It will NOT be HTML-encoded. Therefore you can pass
     *   in HTML code such as an image tag. If this is is coming from end users, you should [[encode()]] it to prevent XSS attacks.
     *   When this option is specified, the checkbox will be enclosed by a label tag.
     * - labelOptions: array, the HTML attributes for the label tag. Do not set this option unless you set the "label" option. The following option is specially handled:
     *   - wrapContent: boolean, when to envolve the input within the label tag.
     *
     * The rest of the options will be rendered as the attributes of the resulting checkbox tag. The values will
     * be HTML-encoded using [[encode()]]. If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated checkbox tag
     * @since 2.0.9
     */
    protected static function booleanInput($type, $name, $checked = false, $options = [])
    {
        // 'checked' option has priority over $checked argument
        if (!isset($options['checked'])) {
            $options['checked'] = (bool) $checked;
        }
        $value = array_key_exists('value', $options) ? $options['value'] : '1';

        if (isset($options['uncheck'])) {
            // add a hidden field so that if the checkbox is not selected, it still submits a value
            $hiddenOptions = [];
            if (isset($options['form'])) {
                $hiddenOptions['form'] = $options['form'];
            }
            // make sure disabled input is not sending any value
            if (!empty($options['disabled'])) {
                $hiddenOptions['disabled'] = $options['disabled'];
            }
            $hidden = static::hiddenInput($name, $options['uncheck'], $hiddenOptions);
            unset($options['uncheck']);
        } else {
            $hidden = '';
        }

        if (isset($options['label'])) {
            $label = $options['label'];
            $labelOptions = $options['labelOptions'] ?? [];
            unset($options['label'], $options['labelOptions']);
            $wrapContent = $labelOptions['wrapContent'];
            unset($labelOptions['wrapContent']);
            if ($wrapContent === true) {
                $content = static::label(static::input($type, $name, $value, $options) . "\n" . $label, null, $labelOptions);
            } else {
                $content = static::input($type, $name, $value, $options) . "\n" . static::label($label, $options['id'] ?? null, $labelOptions);
            }
            return "$hidden\n$content";
        }

        return $hidden . static::input($type, $name, $value, $options);
    }

    /**
     * Renderiza los componentes select-option para el [[dropDownList()]].
     * @param mixed $selection The selected value(s). String/boolean for single or array for multiple selection(s).
     * @param mixed $items The option data items. The array keys are option values, and the array values are the corresponding option labels. 
     *  The array can also be nested (i.e. some array values are arrays too). For each sub-array, an option group will be generated whose label is the key associated with the sub-array. 
     *  If you have a list of data models, you may convert them into the format described above using [[\yii\helpers\ArrayHelper::map()]].
     * 
     * Note, the values and labels will be automatically HTML-encoded by this method, and the blank spaces in the labels will also be HTML-encoded.
     * @param mixed $tagOptions The $options parameter that is passed to the [[dropDownList()]] call. 
     *  This method will take out these elements, if any: "options". See more details in [[dropDownList()]] for the explanation of these elements.
     * @return string
     */
    protected static function renderDropdownListOptions($selection, $items, &$tagOptions = [])
    {
        if (ArrayHelper::isTraversable($selection)) {
            $normalizedSelection = [];
            foreach (ArrayHelper::toArray($selection) as $selectionItem) {
                $normalizedSelection[] = (is_bool($selectionItem)) ? $selectionItem ? '1' : '0' : (string) $selectionItem;
            }
            $selection = $normalizedSelection;
        } elseif (is_bool($selection)) {
            $selection = $selection ? '1' : '0';
        }
        $lines = [];
        $encodeSpaces = ArrayHelper::remove($tagOptions, 'encodeSpaces', false);
        $encode = ArrayHelper::remove($tagOptions, 'encode', true);
        $strict = ArrayHelper::remove($tagOptions, 'strict', false);

        $options = $tagOptions['options'] ?? [];
        unset($tagOptions['options']);
        $options['encodeSpaces'] = ArrayHelper::getValue($options, 'encodeSpaces', $encodeSpaces);
        $options['encode'] = ArrayHelper::getValue($options, 'encode', $encode);

        foreach ($items as $key => $value) {
            if (is_array($value)) {
                $attrs = ['options' => $options, 'encodeSpaces' => $encodeSpaces, 'encode' => $encode, 'strict' => $strict];
                $text = static::renderDropdownListOptions($selection, $value, $attrs);
                $lines[] = $text;
            } else {
                $attrs = $options[$key] ?? [];
                $attrs['value'] = (string) $key;

                if (!array_key_exists('selected', $attrs)) {
                    $selected = false;
                    if ($selection !== null) {
                        if (ArrayHelper::isTraversable($selection)) {
                            $selected = ArrayHelper::isIn((string) $key, $selection, $strict);
                        } elseif ($key === '' || $selection === '') {
                            $selected = $selection === $key;
                        } elseif ($strict) {
                            $selected = !strcmp((string) $key, (string) $selection);
                        } else {
                            $selected = $selection == $key;
                        }
                    }
                    $attrs['selected'] = $selected;
                }
                $text = static::tag('div', $encode ? static::encode($value) : $value, ['slot' => 'headline']);
                if ($encodeSpaces) {
                    $text = str_replace(' ', '&nbsp;', $text);
                }

                $lines[] = static::tag("md-select-option", $text, $attrs);
            }

        }
        return implode("\n", $lines);
    }

    /**
     * Renderiza los elementos `md-list-item` que integran el contenido del componente web `md-list`.
     * @param array $items Los elementos de datos de la opción. Cada elemento del array puede ser un texto o un array.
     * @param array $parentTagOptions El parámetro $option pasado a su elemento superior [[list()]]. Este método obtendrá estos elementos, si existe: "options". 
     *  Vea más detalles en [[list()]] para la explicación de estos elementos.
     * @return string
     */
    protected static function renderListItems(array $items, array $parentTagOptions): string
    {
        $lines = [];
        $encodeSpaces = (bool) ArrayHelper::remove($parentTagOptions, 'encodeSpaces', false);
        $encode = (bool) ArrayHelper::remove($parentTagOptions, 'encode', true);

        foreach ($items as $i => $item) {
            if (is_array($item)) {
                if (isset($item['visible']) && !$item['visible']) {
                    unset($items[$i]);
                    continue;
                }

                if (isset($item['options']['href'])) {
                    $item['options']['href'] = \yii\helpers\Url::to($item['options']['href']);
                }

                if (!isset($item['options']['type'])) {
                    $item['options']['type'] = 'text';
                }

                $text = isset($item['overline']) ? static::tag('div', $item['overline'], ['slot' => 'overline']) : '';
                // 
                $text .= isset($item['headline']) ? static::tag('div', $item['headline'], ['slot' => 'headline']) : $item['headline'];
                //
                $text .= isset($item['leading-icon']) ? static::tag('md-icon', $item['leading-icon'], ['slot' => 'start']) : '';
                $text .= isset($item['supporting-text']) ? static::tag('div', $item['supporting-text'], ['slot' => 'supporting-text']) : '';
                $text .= isset($item['trailing-supporting-text']) ? static::tag('div', $item['trailing-supporting-text'], ['slot' => 'trailing-supporting-text']) : '';
                $text .= isset($item['trailing-icon']) ? static::tag('md-icon', $item['trailing-icon'], ['slot' => 'end']) : '';

                if ($encodeSpaces) {
                    $text = str_replace(' ', '&nbsp;', $text);
                }

                $lines[] = (isset($item['options']['type']) && $item['options']['type'] == 'divider') ? static::tag('md-divider', '', $item['options']) : static::tag('md-list-item', $text, $item['options']);
            } else {
                $text = $encode ? static::encode($item) : $item;
                if ($encodeSpaces) {
                    $text = str_replace(' ', '&nbsp;', $text);
                }

                $lines[] = static::tag('md-list-item', $text);
            }
        }

        return implode("\n", $lines);
    }

    #endregion

    /**
     * If `maxlength` option is set true and the model attribute is validated by a string validator,
     * the `maxlength` option will take the max value of [[\yii\validators\StringValidator::max]] and
     * [[\yii\validators\StringValidator::length]].
     * @param \yii\base\Model $model the model object
     * @param string $attribute the attribute name or expression.
     * @param array $options the tag options in terms of name-value pairs.
     */
    private static function normalizeMaxLength($model, $attribute, &$options)
    {
        if (isset($options['maxlength']) && $options['maxlength'] === true) {
            unset($options['maxlength']);
            $attrName = static::getAttributeName($attribute);
            foreach ($model->getActiveValidators($attrName) as $validator) {
                if ($validator instanceof StringValidator && ($validator->max !== null || $validator->length !== null)) {
                    $options['maxlength'] = max($validator->max, $validator->length);
                    break;
                }
            }
        }
    }
}