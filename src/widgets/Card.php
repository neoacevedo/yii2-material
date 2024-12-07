<?php

namespace neoacevedo\yii2\material3\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Card se encarga de renderizar el componente Card de Material Web.
 * 
 * Dado que Material 3 no dispone del componente en web, se usa en su lugar Material Web Components.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://m3.material.io/components/cards/overview#ffeb6746-b6eb-4715-ad11-4a93f9e221ec
 */
class Card extends Widget
{

    const MDC_CARD_TYPE_OUTLINED = 'outlined';

    const MDC_CARD_TYPE_FILLED = 'filled';

    const MDC_CARD_TYPE_ELEVATED = 'elevated';

    public string $title;

    public string $subtitle;

    public string $mediaSrc;

    public array $options = [];

    /**
     * Estas son las series de botones de acción que contiene el componente.
     * @see https://github.com/material-components/material-components-web/tree/master/packages/mdc-card#actions
     * @var array
     */
    public array $actions = [];

    public array $contentOptions = [];

    public array $mediaOptions = [];

    public array $titleOptions = [];

    public array $subtitleOptions = [];

    public array $actionsOptions = [];


    public function init(): void
    {
        parent::init();

        $this->initOptions();

        echo Html::beginTag('div', $this->options) . "\n";
        echo $this->renderContentBegin() . "\n";
        if (count($this->actions) == 0) {
            echo Html::tag("md-ripple", '') . "\n";
        }
        if (isset($this->title)) {
            echo $this->renderHeader() . "\n";
        }

    }

    public function run(): void
    {
        echo "\n" . Html::endTag('div'); // content
        if (count($this->actions) > 0) {
            echo $this->renderActionButtons() . "\n";
        }
        echo "\n" . Html::endTag('div'); // card
    }

    protected function initOptions(): void
    {
        $this->options = array_merge([
            'id' => $this->getId()
        ], $this->options);

        $variant = 'mdc-card--';
        if (!isset($this->options['variant'])) {
            $variant .= self::MDC_CARD_TYPE_OUTLINED;
        } else {
            $variant .= $this->options['variant'];
        }

        unset($this->options['variant']);

        Html::addCssClass($this->options, ['widget' => "mdc-card $variant"]);
    }

    protected function renderActionButtons(): string
    {
        $content = '';
        Html::addCssClass($this->actionsOptions, ['widget' => 'md-card__actions']);

        if (isset($this->actions['buttons'])) {
            $content .= implode("\n", $this->actions['buttons']);
            Html::tag('div', $content, options: ['class' => 'mdc-card__action-buttons']);
        }

        if (isset($this->actions['icons'])) {
            $content .= implode("\n", $this->actions['icons']);
            Html::tag('div', $content, options: ['class' => 'mdc-card__action-icons']);
        }

        return Html::tag('div', $content, $this->actionsOptions);
    }

    protected function renderContentBegin(): string
    {
        if (isset($this->mediaSrc)) {
            Html::addCssClass($this->contentOptions, ['widget' => 'mdc-card__primary-action']);
        }
        if (count($this->actions) > 0) {
            $this->contentOptions = array_merge([
                'style' => 'cursor: inherit;'
            ], $this->contentOptions);
        }
        return Html::beginTag('div', $this->contentOptions);
    }

    protected function renderHeader(): string
    {
        $content = $title = $subtitle = '';

        if (isset($this->mediaSrc)) {
            Html::addCssClass($this->mediaOptions, ['widget' => 'mdc-card__media mdc-card__media--16-9']);
            $content .= Html::tag('div', '', array_merge($this->mediaOptions, ['style' => "background-image: url(\"{$this->mediaSrc}\")"]));
        }

        if (isset($this->title)) {
            Html::addCssClass($this->titleOptions, ['widget' => 'mdc-typography--headline6']);
            $title .= Html::tag('h5', $this->title, $this->titleOptions);
        } else {
            $title .= '';
        }

        if (isset($this->subtitle)) {
            Html::addCssClass($this->subtitleOptions, ['widget' => 'mdc-typography--subtitle2']);
            $subtitle .= Html::tag('h6', $this->subtitle, $this->subtitleOptions);
        } else {
            $subtitle .= '';
        }

        $content .= Html::tag('div', $title . "\n" . $subtitle, ['class' => 'mdc-card__body']);

        return $content;

    }

}