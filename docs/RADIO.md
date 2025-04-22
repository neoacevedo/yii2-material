## Radio

De acuerdo a los lineamientos de Material, los radio no deberían estar dentro de la etiqueta `label` ya que puede detener a los lectores de pantalla de 
obtener correctamente el número de radios dentro de un grupo: https://material-web.dev/components/radio/#label

```php
<?php
// De forma directa
echo Radio::widget([
    'name' => 'radio-input'
    'options' => [
        'value' => '1',
        'label' => 'Label envoltorio para el componente',
        'labelOptions' => [
            'wrapContent' => false, // true para que el label encierre al componente
        ]
    ]    
]);

// Usando la clase auxiliar Html:
echo \neoacevedo\yii2\material\Html::radio('radio-input', false, [
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
<md-radio name="radio-input" value="1"></md-radio>
```