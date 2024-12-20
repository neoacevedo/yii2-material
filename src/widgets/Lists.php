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

use yii\base\Widget;
use yii\helpers\Html;

/**
 * List widget for Yii2 that uses Material Web's list components. 
 */
class Lists extends Widget
{

    public string $label = '';

    public bool $encode = true;

    /**
     * @var array The data to be displayed in the list.
     * Each item can be a single text or html, or an array with the following structure:
     * - overline: string, optional, the overline text.
     * - content: string, the main content. Maybe a single text or HTML content.
     * - supporting-text: string, optional, the secondary text.
     * - trailing-supprting-text: string, optional, a secondary text at the end of the supporting text.
     * - icon: string, the icon to display.
     * - options: array, the key value pair for additional configuration options.
     * @see https://material-web.dev/components/list/#properties-1
     */
    public $items = [];

    /**
     * @var array Configuration options for the list.
     */
    public $options = [];

    /**
     * @inheritDoc 
     */
    public function run(): void
    {
        $this->initOptions();

        echo Html::beginTag('md-list', $this->options);

        foreach ($this->items as $data) {
            echo Html::beginTag('md-list-item') . "\n";
            if (is_array($data)) {
                echo Html::beginTag('md-list-item', $data['options'] ?? []) . "\n";
                echo isset($data['overline']) ? Html::tag('div', $data['overline'], ['slot' => 'overline']) : '';
                // 
                echo "<a href='#'>Texto</a>\n";
                // echo $this->encode ? Html::encode("{$data['content']}\n") : ". <a href=''>{$data['content']}</a>\n";
                //
                echo isset($data['leading-icon']) ? Html::tag('md-icon', $data['start'], ['slot' => 'start']) : '';
                echo isset($data['supporting-text']) ? Html::tag('div', $data['supporting-text'], ['slot' => 'supporting-text']) : '';
                echo isset($data['trailing-supporting-text']) ? Html::tag('div', $data['trailing-supporting-text'], ['slot' => 'trailing-supporting-text']) : '';
                echo isset($data['trailing-icon']) ? Html::tag('md-icon', $data['end'], ['slot' => 'end']) : '';
            } else {
                echo $this->encode ? Html::encode("$data\n") : "$data\n";
            }
            echo Html::endTag('md-list-item') . "\n"; // Closing the list item tag
        }

        echo Html::endTag('md-list') . "\n"; // Close the list container 
    }

    protected function initOptions(): void
    {
        $this->options = array_merge([
            'id' => $this->id,
            'aria-label' => $this->label,
        ], $this->options);
    }
}
