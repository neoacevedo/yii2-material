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

namespace neoacevedo\yii2\material3;

use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;

abstract class Material3BaseHtml extends BaseHtml
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
     * Genera un botón de ícono.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * 
     * The following special options are recognized:
     * - icon: string, the button's icon. See [[https://m3.material.io/components/icon-buttons/overview#a7ec0732-5bee-4b7e-9e64-333678d2b02b]] for icons.
     * - variant: string, the button variant used in Material 3.
     *   See [[https://m3.material.io/components/icon-buttons/specs#c2a5b845-c705-4bf3-83ad-6c99f25cb408]] for variants.
     * 
     * @return string
     */
    public static function iconButton($options): string
    {
        $variant = $options['variant'] ?? 'outlined';

        $content = "<md-icon>{$options['icon']}</md-icon>\n";

        unset($options['variant']);

        return static::tag("md-$variant-icon-button", $content, $options);
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
     * 
     * @return string the generated button tag
     */
    public static function button($content = 'Button', $options = [])
    {
        if (!isset($options['type'])) {
            $options['type'] = 'button';
        }

        $variant = $options['variant'] ?? 'outlined';

        unset($options['variant']);

        return static::tag("md-$variant-button", $content, $options);
    }

    /**
     * Generates a checkbox input.
     * @param string $name the name attribute.
     * @param bool $checked whether the checkbox should be checked.
     * @param array $options the tag options in terms of name-value pairs.
     * See [[booleanInput()]] for details about accepted attributes.
     *
     * @return string the generated checkbox tag
     */
    // public static function checkbox($name, $checked = false, $options = [])
    // {
    //     return static::booleanInput('checkbox', $name, $checked, $options);
    // }

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
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        $value = isset($options['value']) ? $options['value'] : static::getAttributeValue($model, $attribute);
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
     * @inheritDoc
     */
    public static function input($type, $name = null, $value = null, $options = [])
    {
        $options['name'] = $name;
        $options['value'] = $value === null ? null : (string) $value;

        if ($type === 'text') {
            $variant = $options['variant'] ?? 'outlined';

            unset($options['variant']);

            return static::tag("md-$variant-$type-field", '', $options);
        }

        return static::tag("md-$type", '', $options);

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
     * @param string $type the input type. This can be either `radio` or `checkbox`.
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
     * - labelOptions: array, the HTML attributes for the label tag. Do not set this option unless you set the "label" option.
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

        // if (isset($options['label'])) {
        //     $label = $options['label'];
        //     $labelOptions = isset($options['labelOptions']) ? $options['labelOptions'] : [];
        //     unset($options['label'], $options['labelOptions']);
        //     $content = static::label(static::input($type, $name, $value, $options) . ' ' . $label, null, $labelOptions);
        //     return $content;
        // }

        return static::input($type, $name, $value, $options);
    }

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