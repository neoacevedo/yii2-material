## Button

```php
<?php 

// De forma directa.
// 'variant' es opcional.
echo Button::widget([
    'label' => 'Filled button with icon'
    'options' => [
        'icon' => 'home', 
        'variant' => IconButton::TYPE_FILLED
    ]
]); 
...
// Usando la clase auxiliar Html
echo \neoacevedo\yii2\material\Html::button([
    'label' => 'Outlined button with icon'
    'options' => [
        'icon' => 'dictionary', 
        'variant' => IconButton::TYPE_FILLED
    ]
]);

?>
```

Este componente web de Material también puede ser usado de manera directa en el html:

```html
<md-filled-button>
    ...
</md-outlined-button>
```
