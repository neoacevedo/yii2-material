## Card

```php
<?php
...
$css = <<<CSS
.card {
    width: 192px;
}

.card.content {
    display: flex;
    flex-direction: column;
    flex: 1;
    justify-content: space-between;
    padding: 8px;
    gap: 16px;
}
CSS;

$this->registerCss($css);
?>
<main class="row">
    <?php
    \neoacevedo\yii2\material\widgets\Card::begin([
        'options' => [
            'class' => 'card', 
            'type' => Card::MD_CARD_TYPE_FILLED
        ],
        'actions' => [
            'icons' => [
                Html::iconButton(['icon' => 'dictionary']),
                Html::iconButton(['icon' => 'bookmark'])
            ]
        ]
    ]);
    ?>
    <h5 class="md-sys-typescale-headline-small-font">Agregue su código espagueti</h5>
    <?php
    neoacevedo\yii2\material\widgets\Card::end();
    ?>
</main>
```

Este componente web de Material también puede ser usado de manera directa en el html:

```html
<md-filled-card>
...
</md-filled-card>
```