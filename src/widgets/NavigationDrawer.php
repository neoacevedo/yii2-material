<?php


namespace neoacevedo\yii2\material\widgets;

use neoacevedo\yii2\material\Html;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * NavigationDrawer renderiza
 */
class NavigationDrawer extends Widget
{

    /**
     * Lista de los elementos del Navigation Drawer. Cada elemento debe ser un array con la siguiente estructura:
     * - content: string, un texto o el contenido HTML del elemento. Si [[encode]] es true, el contenido será codificado en HTML.
     * - options: array, opcional, 
     * - overline: string, opcional, texto de encabezado para cada elemento.
     * - supporting-text: string, opcional, texto secundario.
     * - trailing-supporting-text: string, opcional
     * 
     * @var array
     */
    public array $items = [];

    public array $options = [];

    public function init(): void
    {
        parent::init();
        $view = $this->getView();
        $view->registerJs(<<<JS
            const navigationDrawer = new mdc.drawer.MDCDrawer(document.querySelector('.mdc-drawer'));
JS, \yii\web\View::POS_END);
        Html::addCssClass($this->options, ['widget' => 'mdc-drawer']);
    }

    public function run(): void
    {
        echo Html::beginTag("aside", $this->options) . "\n";
        echo Html::beginTag("div", ['class' => 'mdc-drawer__content']) . "\n";
        if (!empty($this->items)) {
            echo $this->renderItems($this->items);
        }
        echo Html::endTag("aside") . "\n";
        echo Html::tag("div", '', ['class' => 'mdc-drawer-scrim']) . "\n";
    }

    // protected function normalizeItems($items, &$active)
    // {
    //     foreach ($items as $i => $item) {
    //         if (isset($item['visible']) && !$item['visible']) {
    //             unset($items[$i]);
    //             continue;
    //         }
    //         if (!isset($item['label'])) {
    //             $item['label'] = '';
    //         }
    //         $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
    //         $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
    //         $hasActiveChild = false;
    //         if (isset($item['items'])) {
    //             $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
    //             if (empty($items[$i]['items']) && $this->hideEmptyItems) {
    //                 unset($items[$i]['items']);
    //                 if (!isset($item['url'])) {
    //                     unset($items[$i]);
    //                     continue;
    //                 }
    //             }
    //         }
    //         if (!isset($item['active'])) {
    //             if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
    //                 $active = $items[$i]['active'] = true;
    //             } else {
    //                 $items[$i]['active'] = false;
    //             }
    //         } elseif ($item['active'] instanceof Closure) {
    //             if (call_user_func($item['active'], $item, $hasActiveChild, $this->isItemActive($item), $this)) {
    //                 $active = $items[$i]['active'] = true;
    //             } else {
    //                 $items[$i]['active'] = false;
    //             }
    //         } elseif ($item['active']) {
    //             $active = true;
    //         }
    //     }
    //     return array_values($items);
    // }

    /**
     * SRenderiza los elementos del menú.
     * @param array $items
     * @return string
     */
    protected function renderItems(array $items): string
    {
        return Lists::widget([
            'items' => $items
        ]);
    }
}