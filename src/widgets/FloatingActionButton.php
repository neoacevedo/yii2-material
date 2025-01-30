<?php

namespace neoacevedo\yii2\material\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Summary of FloatingActionButton
 */
class FloatingActionButton extends Widget
{
    public string $label;

    public string $icon;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();
        if (!isset($this->icon)) {
            throw new \yii\base\InvalidConfigException("El atributo 'icon' es requerido.");
        }
        $this->options = array_merge([
            'id' => $this->id,
            'label' => $this->label
        ], $this->options);
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        $html = Html::beginTag(name: 'md-fab', options: $this->options);
        $html .= Html::tag(name: 'md-icon', content: $this->icon);
        $html .= Html::endTag(name: 'md-fab');

        return $html;
    }
}