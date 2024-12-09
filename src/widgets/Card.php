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

    /**
     * @var string the title content in the card.
     */

    public string $title;

    /**
     * @var string the subtitle content in the card.
     */
    public string $subtitle;

    /**
     * @var string the URL for the image.
     */
    public string $mediaSrc;

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
     * The following special options are recognized:
     *
     * - `variant`: the tag name of the container element. Defaults to `div`. Setting it to `false` will not render a container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @see https://m3.material.io/components/cards/overview#7aa694fb-16f0-44fb-adf2-be0288ec22dc for the card variant (types).
     */
    public array $options = [];

    /**
     * Estas son las series de botones de acción que contiene el componente.
     * @see https://github.com/material-components/material-components-web/tree/master/packages/mdc-card#actions
     * @var array
     */
    public array $actions = [];

    /**
     * @var array body options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $contentOptions = [];

    /**
     * @var array body options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $mediaOptions = [];

    /**
     * @var array title options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $titleOptions = [];

    /**
     * @var array subtitle options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $subtitleOptions = [];

    /**
     * @var array action options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $actionsOptions = [];

    /**
     * @inheritDoc
     */
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

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        echo "\n" . Html::endTag('div'); // content
        if (count($this->actions) > 0) {
            echo $this->renderActionButtons() . "\n";
        }
        echo "\n" . Html::endTag('div'); // card
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     * @return void
     */
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

    /**
     * Renders the HTML markup for the action buttons in the footer of the card
     * @return string
     */
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

    /**
     * Renders the opening tag of the content.
     * @return string
     */
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

    /**
     * Renders the header HTML markup of the card.
     * @return string
     */
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