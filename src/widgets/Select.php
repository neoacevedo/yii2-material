<?php


namespace neoacevedo\yii2\material\widgets;

use neoacevedo\yii2\material\Html;
use yii\base\Widget;

class Select extends Widget
{
    /**
     * The input name
     * @var string
     */
    public string $name;

    /**
     * The option data items. The array keys are option values, and the array values are the corresponding option labels. 
     * The array can also be nested (i.e. some array values are arrays too). 
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array. If you have a list of data models, 
     * you may convert them into the format described above using [[\yii\helpers\ArrayHelper::map(]]).
     * Note, the values and labels will be automatically HTML-encoded by this method, and the blank spaces in the labels will also be HTML-encoded.
     * @var mixed
     */
    public mixed $selection = null;

    /**
     * The option data items. The array keys are option values, and the array values are the corresponding option labels. 
     * The array can also be nested (i.e. some array values are arrays too). 
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array. 
     * If you have a list of data models, you may convert them into the format described above using [[\yii\helpers\ArrayHelper::map()]]. 
     * Note, the values and labels will be automatically HTML-encoded by this method, and the blank spaces in the labels will also be HTML-encoded.
     * @var array
     */
    public array $items = [];

    /**
     * The tag options in terms of name-value pairs. The following options are specially handled:
     *
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
     *   Defaults to `true`. This option is available since 2.0.3.
     * - strict: boolean, if `$selection` is an array and this value is true a strict comparison will be performed on `$items` keys. Defaults to false.
     * @var array
     */
    public array $options = [];

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        $this->options = array_merge([
            'id' => $this->id,
            'type' => 'select-option'
        ], $this->options);

        echo Html::dropDownList(name: $this->name, selection: $this->selection, items: $this->items, options: $this->options);
    }
}