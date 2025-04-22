## Checkbox

```php
<?php
// De forma directa
echo Checkbox::widget([
    'name' => 'input-check'
    'options' => [
        'value' => '1',
        'label' => 'Label envoltorio para el componente',
        'labelOptions' => [
            'wrapContent' => false, // true para que el label encierre al componente
        ]
    ]    
]);

// Usando la clase auxiliar Html:
echo \neoacevedo\yii2\material\Html::checkbox('input-check', false, [
    'value' => '1',
    'label' => 'Label envoltorio para el componente',
    'labelOptions' => [
        'wrapContent' => false, // true para que el label encierre al componente
    ]
]);
?>
```

Este componente web de Material también puede ser usado de manera directa en el html:

```html
<md-checkbox name="input-radio" value="1"></md-checkbox>
```