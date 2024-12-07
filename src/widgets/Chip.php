<?php

namespace neoacevedo\yii2\material3\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Chip se encarga de renderizar el componente Chip de Material Web.
 * @see https://material-web.dev/components/chip/
 * @see https://m3.material.io/components/chips/overview
 */
class Chip extends Widget
{
    const TYPE_ASSIST = 'assist';

    const TYPE_FILTER = 'filter';

    const TYPE_INPUT = 'input';

    const TYPE_SUGGESTION = 'suggestion';

    public $chips = [];

    public function run(): string
    {
        return Html::tag('md-chip-set', $this->renderChips());
    }

    protected function renderChips(): string
    {
        $content = '';
        foreach ($this->chips as $chip) {
            $type = $chip['type'];

            if (!isset($chip['options']['has-icon'])) {
                $chip['options']['has-icon'] = false;
            } else {
                if (filter_var($chip['options']['icon'], FILTER_VALIDATE_URL | FILTER_VALIDATE_EMAIL)) {
                    $content .= Html::img($chip['options']['icon']);
                }
            }

            if (!isset($chip['options']['has-selected-icon'])) {
                $chip['options']['has-icon'] = false;
            } else {
                $content .= Html::tag('md-icon', $chip['options']['selected-icon'], ['slot' => 'icon']);
            }

            unset($chip['options']['type'], $chip['options']['selected-icon']);

            $content .= Html::tag("md-$type-chip", $content, $chip['options']) . "\n";
        }

        return $content;
    }
}