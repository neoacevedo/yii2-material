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

use yii\base\Widget;
use yii\helpers\Html;

/**
 * List widget for Yii2 that uses Material Web's list components. 
 */
class Lists extends Widget
{
    /**
     * @var array The data to be displayed in the list.
     * Each item can be a single text or html, or an array with the following structure:
     * - headline: string, the headline text.
     * - supporting-text: string, the secondary text. Maybe a single text or HTML content.
     * - trailing-supprting-text: string, a supporting text at the end of the supporting text.
     * - icon: string, the icon to display.
     */
    public $items = [];

    /**
     * @var array Configuration options for the list.
     */
    public $options = [];

    /**
     * @inheritDoc 
     */
    public function init(): void
    {
        parent::init();

        // Set default options for the list
        $this->options['class'] = 'list'; // Default class for Material Web lists
        $this->options['padding'] = '10px';  // Optional padding for the list items
    }

    /**
     * @inheritDoc 
     */
    public function run(): void
    {
        echo Html::beginTag('md-list', $this->options);
        foreach ($this->items as $data) {
            echo Html::beginTag('md-list-item') . "\n";
            if (is_array($data)) {
                echo Html::beginTag('md-list-item', $data['options']) . "\n";
                echo Html::tag('div', $data['headline'], ['slot' => 'headline']);
                echo Html::tag('div', $this->options['encode'] ? Html::encode($data['supporting-text']) : $data['supporting-text'], ['slot' => 'supporting-text']);
                echo isset($data['leading-icon']) ? Html::tag('md-icon', $data['start'], ['slot' => 'start']) : '';
                echo Html::tag('div', $data['trailing-supporting-text'], ['slot' => 'trailing-supporting-text']);
                echo isset($data['trailing-icon']) ? Html::tag('md-icon', $data['end'], ['slot' => 'end']) : '';
            } else {
                echo $this->options['encode'] ? Html::encode("$data\n") : "$data\n";
            }
            echo Html::endTag('md-list-item') . "\n"; // Closing the list item tag
        }

        echo Html::endTag('md-list') . "\n"; // Close the list container 
    }
}
