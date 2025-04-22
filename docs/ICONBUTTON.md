## Icon Button

```php
<?php 

// De forma directa.
// 'variant' es opcional.
echo IconButton::widget(['icon' => 'home', 'variant' => IconButton::TYPE_FILLED]); 
...
// Usando la clase auxiliar Html
echo \neoacevedo\yii2\material\Html::iconButton(['icon' => 'dictionary']);

?>
```

Este componente web de Material también puede ser usado de manera directa en el html:

```html
<md-filled-icon-button>
    <md-icon>home</md-icon>
</md-filled-icon-button>
```
