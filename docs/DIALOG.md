## Dialog

```php
<?php
Dialog::begin([
    'options' => [
        'open' => true,
        'no-focus-trap' => "true",
        'type' => 'alert',
        'quick' => true
    ],
    'headerOptions' => [
        'showCloseButton' => true
    ],
    'title' => 'Dialog',
    'buttons' => [
        Button::widget([
            'label' => 'Cancelar',
            'options' => [
                'type' => Button::TYPE_TEXT,
                'form' => 'form',
                'value' => 'cancel',
            ]
        ]),
        Button::widget([
            'label' => 'Aceptar',
            'options' => [
                'type' => Button::TYPE_TEXT,
                'form' => 'form',
                'value' => 'ok',
            ]
        ])
    ]
]);
?>
A simple dialog with free-form content.
<?php
Dialog::end();
?>
```

Este componente web de Material también puede ser usado de manera directa en el html:

```html
<md-dialog>
...
</md-dialog>
```