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

use Exception;
use neoacevedo\yii2\material\Html;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveField;

/**
 *
 */
class Material3ActiveField extends ActiveField
{

    /**
     * @var string|null optional template to render the `{input}` placeholder content
     */
    public $inputTemplate = null;

    public $inputOptions = ['class' => ''];

    /**
     * @var array
     */
    public $checkOptions = [];

    /**
     * @inheritdoc
     */
    public $labelOptions = [];

    /**
     * @var array options for the wrapper tag, used in the `{beginWrapper}` placeholder
     */
    public $wrapperOptions = [];

    /**
     * @var string the template for checkboxes in default layout
     */
    public $checkTemplate = "{input}\n{error}\n{hint}";

    /**
     * @var string the `enclosed by label` template for checkboxes and radios in default layout
     */
    public $checkEnclosedTemplate = "<div class=\"form-check\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>";

    /**
     * @var string the template for radios in default layout
     * @since 2.0.5
     */
    public $radioTemplate = "<div class=\"form-check\">\n{input}\n{label}\n{error}\n{hint}\n</div>";

    /**
     * @inheritDoc
     */
    public $template = "{beginWrapper}\n{input}\n{endWrapper}";

    /**
     * @var bool whether to render the error. Default is `true` except for layout `inline`.
     */
    public $enableError = true;
    /**
     * @var bool whether to render the label. Default is `true`.
     */
    public $enableLabel = true;


    /**
     * @inheritDoc
     */
    public function checkbox($options = [], $enclosedByLabel = true)
    {
        $checkOptions = $this->checkOptions;
        $options = ArrayHelper::merge($checkOptions, $options);
        $labelOptions = ArrayHelper::remove($options, 'labelOptions', []);
        $wrapperOptions = ArrayHelper::remove($options, 'wrapperOptions', []);
        Html::removeCssClass($options, 'form-control');
        $this->labelOptions = ArrayHelper::merge($this->labelOptions, $labelOptions);
        $this->wrapperOptions = ArrayHelper::merge($this->wrapperOptions, $wrapperOptions);

        if (!isset($options['template'])) {
            // if ($switch) {
            //     $this->template = $enclosedByLabel ? $this->switchEnclosedTemplate : $this->switchTemplate;
            // } else {
            //     $this->template = $enclosedByLabel ? $this->checkEnclosedTemplate : $this->checkTemplate;
            // }
            $this->template = $enclosedByLabel ? $this->checkEnclosedTemplate : $this->checkTemplate;
        } else {
            $this->template = $options['template'];
        }

        unset($options['template']);

        if ($enclosedByLabel) {
            if (isset($options['label'])) {
                $this->parts['{labelTitle}'] = $options['label'];
            }
        }

        $this->parts['{input}'] = Html::activeCheckbox($this->model, $this->attribute, $options);
        return $this;
    }

    /**
     * Renders a list of checkboxes. A checkbox list allows multiple selection, like [[listBox()]]. As a result, the
     * corresponding submitted value is an array. The selection of the checkbox list is taken from the value of the
     * model attribute.
     *
     * @param  array  $items  the data item used to generate the checkboxes. The array values are the labels, while the
     * array keys are the corresponding checkbox values. Note that the labels will NOT be HTML-encoded, while the
     * values will be encoded.
     * @param  array  $options  options (name => config) for the checkbox list. The following options are specially
     * handled:
     *
     * - `custom`: _bool_, whether to render bootstrap 4.x custom checkbox/radio styled control. Defaults to `false`.
     *    This is applicable only for Bootstrap 4.x forms.
     * @return ActiveField object
     * @throws InvalidConfigException
     * - `unselect`: _string_, the value that should be submitted when none of the checkboxes is selected. By setting this
     *   option, a hidden input will be generated.
     * - `separator`: _string_, the HTML code that separates items.
     * - `inline`: _boolean_, whether the list should be displayed as a series on the same line, default is false
     * - `item: callable, a callback that can be used to customize the generation of the HTML code corresponding to a
     *   single item in $items. The signature of this callback must be:
     * ~~~
     * function ($index, $label, $name, $checked, $value)
     * ~~~
     *
     * where `$index` is the zero-based index of the checkbox in the whole list; `$label` is the label for the checkbox;
     * and `$name`, `$value` and `$checked` represent the name, value and the checked status of the checkbox input.
     *
     */
    public function checkboxList($items, $options = [])
    {
        if (!isset($options['item'])) {
            $this->template = str_replace("\n{error}", '', $this->template);
            $itemOptions = $options['itemOptions'] ?? [];
            $encode = ArrayHelper::getValue($options, 'encode', true);
            $itemCount = count($items) - 1;
            $error = $this->error()->parts['{error}'];
            $options['item'] = function ($i, $label, $name, $checked, $value) use ($itemOptions, $encode, $itemCount, $error) {
                $options = array_merge($this->checkOptions, [
                    'label' => $encode ? Html::encode($label) : $label,
                    'value' => $value,
                ], $itemOptions);
                $wrapperOptions = ArrayHelper::remove($options, 'wrapperOptions', ['class' => ['widget' => 'form-check']]);
                if ($this->inline) {
                    Html::addCssClass($wrapperOptions, ['inline' => 'form-check-inline']);
                }

                $html = Html::beginTag('div', $wrapperOptions) . "\n" .
                    Html::checkbox($name, $checked, $options) . "\n";
                if ($itemCount === $i) {
                    $html .= $error . "\n";
                }
                $html .= Html::endTag('div') . "\n";

                return $html;
            };
        }

        parent::checkboxList($items, $options);

        return $this;
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function dropDownList($items, $options = [])
    {
        $this->initDisability($options);
        $newBsCss = ($this->form->isBs(5) ? 'form' : 'custom') . '-select';
        $class = $this->isCustomControl($options) ? $newBsCss : $this->addClass;
        Html::addCssClass($options, $class);

        return parent::dropDownList($items, $options);
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function fileInput($options = [])
    {
        return parent::fileInput($options);
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function input($type, $options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        if ($this->form->validationStateOn === \yii\widgets\ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        // $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeInput($type, $this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function label($label = null, $options = [])
    {
        if (is_bool($label)) {
            $this->enableLabel = $label;
        } else {
            $this->enableLabel = true;
            if ($label !== null) {
                $options['label'] = $label;
            }
            $this->renderLabelParts($label, $options);
            parent::label($label, $options);
        }

        return $this;
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function passwordInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options, $options, ['type' => 'password']);

        if ($this->form->validationStateOn === \yii\widgets\ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->parts['{input}'] = Html::activePasswordInput($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{beginWrapper}'])) {
                $options = $this->wrapperOptions;
                $tag = ArrayHelper::remove($options, 'tag', 'div');
                $this->parts['{beginWrapper}'] = Html::beginTag($tag, $options);
                $this->parts['{endWrapper}'] = Html::endTag($tag);
            }

            if ($this->enableLabel === false) {
                $this->parts['{label}'] = '';
                $this->parts['{beginLabel}'] = '';
                $this->parts['{labelTitle}'] = '';
                $this->parts['{endLabel}'] = '';
            } elseif (!isset($this->parts['{beginLabel}'])) {
                $this->renderLabelParts();
            }

            if (!isset($this->parts['{error}'])) {
                $this->error();
            }

            if ($this->enableError === false) {
                $this->parts['{error}'] = '';
            }

            if (!isset($this->parts['{hint}'])) {
                $this->hint(null);
            }

            if ($this->inputTemplate) {
                $options = $this->inputOptions;

                if ($this->form->validationStateOn === \yii\widgets\ActiveForm::VALIDATION_STATE_ON_INPUT) {
                    $this->addErrorClassIfNeeded($options);
                }
                $this->addAriaAttributes($options);

                $input = $this->parts['{input}'] ?? Html::activeTextInput($this->model, $this->attribute, $options);

                $this->parts['{input}'] = strtr($this->inputTemplate, ['{input}' => $input]);
            }

            $content = strtr($this->template, $this->parts);

        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }

        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }

    /**
     * Renders a text input.
     * This method will generate the `name` and `value` tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     *
     * The following special options are recognized:
     * - `maxlength`: int|bool, when `maxlength` is set `true` and the model attribute is validated
     *   by a string validator, the `maxlength` option will take the value of [[\yii\validators\StringValidator::max]].
     *   This is available since version 2.0.3.
     * - `filled`: int|bool, when it is se to `true` then the text input will be rendered as filled type. {@see https://m3.material.io/components/text-fields/overview#83ab732c-c40d-4470-8bc0-18e8d014acff}
     *
     * Note that if you set a custom `id` for the input element, you may need to adjust the value of [[selectors]] accordingly.
     * 
     *
     * @return $this the field object itself.
     */
    public function textInput($options = []): static
    {
        $options = array_merge($this->inputOptions, $options);

        if ($this->form->validationStateOn === \yii\widgets\ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        // $this->adjustLabelFor($options);

        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function textarea($options = [])
    {
        $options = array_merge($this->inputOptions, $options, ['type' => 'textarea']);

        if ($this->form->validationStateOn === \yii\widgets\ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * Render the label parts
     *
     * @param  string|null  $label  the label or null to use model label
     * @param  array  $options  the tag options
     */
    protected function renderLabelParts($label = null, $options = [])
    {
        $options = array_merge($this->labelOptions, $options);
        if ($label === null) {
            if (isset($options['label'])) {
                $label = $options['label'];
                unset($options['label']);
            } else {
                $attribute = Html::getAttributeName($this->attribute);
                $label = Html::encode($this->model->getAttributeLabel($attribute));
            }
        }
        if (!isset($options['for'])) {
            $options['for'] = Html::getInputId($this->model, $this->attribute);
        }
        $this->parts['{beginLabel}'] = Html::beginTag('label', $options);
        $this->parts['{endLabel}'] = Html::endTag('label');
        if (!isset($this->parts['{labelTitle}'])) {
            $this->parts['{labelTitle}'] = $label;
        }
    }

}
