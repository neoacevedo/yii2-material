Yii2 Material 3
============

<p align="center">
<svg width="100" height="100" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" fill="#757575" r="12"/><path d="m3.6 3.6h16.8v16.8h-16.8z" fill="#bdbdbd"/><path d="m20.4 3.6-8.4 16.8-8.4-16.8z" fill="#fff"/><path d="m0 0h24v24h-24z" fill="none"/></svg>
</p>

Esta es una extensión primaria para [Yii framework 2.0](https://www.yiiframework.com). Encapsula componentes de [Material Design](https://m3.material.io/) en términos de Widgets Yii.

**NOTA**: Material Web 3 no tiene los componentes `Card`, `Snackbar`, `TopAppBar` ni `NavigationRail`, así que se han creado desde 0 para intentar seguir los lineamientos del diseño de Material 3.

Instalación
------------

La forma preferida de instalar esta extensión es a través de [composer](http://getcomposer.org/download/).

Luego ejecute

```
php composer.phar require --prefer-dist neoacevedo/yii2-material3
```

o agregue

```js
"neoacevedo/yii2-material3": "*"
```

a la sección require de su archivo `composer.json`.

Uso
----

### Card e Icon Buttons

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

### Material3ActiveForm

```php
<?php
<?php
    /**
     * @var Material3ActiveForm
     */
    $form = Material3ActiveForm::begin([
        'id' => 'form'
        
    ]);
    ?>
    ...
    <?php
    Material3ActiveForm::end();
    ?>
?>

```

### Dialog

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

### Material3ActiveField

```php
<?php

// Outlined (default) input
echo $form->field($model, 'username', [
    'options' => ['class' => 'mb-3']
])->textInput();

// Filled input
echo $form->field($model, 'password', [
      'options' => ['class' => 'mb-3']
])->passwordInput(['variant' => 'filled']);

echo $form->field($model, 'remember_me')->checkbox()

?>
```