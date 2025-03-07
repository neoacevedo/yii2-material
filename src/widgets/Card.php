<?php

namespace neoacevedo\yii2\material\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Card se encarga de renderizar el componente Card de Material Web.
 * 
 * Dado que Material 3 no dispone del componente en web, se crea uno desde 0.
 * 
 * Se tiene en cuenta que MWC ahora se encuentra en [modo mantenimiento](https://github.com/material-components/material-web/discussions/5642) y es posible que quede obsoleto.
 * 
 * @see https://m3.material.io/components/cards/overview#ffeb6746-b6eb-4715-ad11-4a93f9e221ec
 */
class Card extends Widget
{

    const MD_CARD_TYPE_OUTLINED = 'outlined';

    const MD_CARD_TYPE_FILLED = 'filled';

    const MD_CARD_TYPE_ELEVATED = 'elevated';

    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is `null`, the corresponding attribute will not be rendered.
     * The following special options are recognized:
     *
     * - `type`: the card type.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @see https://m3.material.io/components/cards/overview#7aa694fb-16f0-44fb-adf2-be0288ec22dc for the card type.
     */
    public array $options = [];

    /**
     * Estas son las series de botones de acción que contiene el componente.
     * Las siguientes opciones son reconocidas:
     * - `icons`: botones de acción de tipo ícono.
     * - `buttons`: botones de acción clásicos. 
     * - `options`: igual que en [[$options]] pero sin la opción `type`.
     * - `iconsActionsOptions`: igual que en [[$options]] pero sin la opción `type`. Agrega atributos HTML al contenedor de los botones de acción tipo ícono.
     * - `buttonsActionsOptions`: igual que en [[$options]] pero sin la opción `type`. Agrega atributos HTML al contenedor de los botones de acción clásicos.
     * @var array
     * @see https://m3.material.io/components/cards/guidelines#2143949d-3645-4c0f-8f91-6fe86bd416a0
     */
    public array $actions = [];

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * @inheritDoc
     */
    public function run(): string
    {
        $type = $this->options['type'] ?? self::MD_CARD_TYPE_ELEVATED;
        unset($this->options['type']);

        $html = Html::beginTag("md-$type-card", $this->options) . "\n";

        switch (count($this->actions)) {
            case 0:
                // echo Html::tag("md-ripple", '') . "\n";
                break;
            default:
                $html .= $this->renderActionButtons() . "\n";
                break;
        }

        $content = ob_get_clean();
        $html .= $content;
        $html .= Html::endTag("md-$type-card"); // card

        return $html;
    }

    /**
     * Renders the HTML markup for the action buttons in the footer of the card
     * @return string
     */
    protected function renderActionButtons(): string
    {
        $content = '';

        if (isset($this->actions['buttons'])) {
            $content .= implode("\n", $this->actions['buttons']);
            Html::tag('div', content: $content, options: array_merge(['slot' => 'actions'], $this->actions['buttonsActionOptions']));
        }

        if (isset($this->actions['icons'])) {
            $content .= implode("\n", $this->actions['icons']);
            Html::tag(name: 'div', content: $content, options: array_merge(['slot' => 'actions'], $this->actions['buttonsActionOptions']));
        }

        return Html::tag(name: 'div', content: $content, options: array_merge(['class' => 'actions'], $this->actions['options']));
    }

}