Yii2 Material 3
============

#### Donaciones:

<img title="" src="Litecoin.jpg" alt="" width="339" data-align="center">

> Que sea software libre, no quiere decir que los servicios públicos lo sean. 



Esta es una extensión primaria para [Yii framework 2.0](https://www.yiiframework.com). Encapsula componentes de [Material Design](https://m3.material.io/) en términos de Widgets Yii.

**NOTA**: Material Web 3 no tiene los componentes `Card`, `Snackbar`, `TopAppBar` ni `NavigationRail`, así que se han creado desde 0 intentando seguir los lineamientos del diseño de Material 3.

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

### Material3ActiveForm y Material3ActiveField

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
    // Outlined (default) input
    echo $form->field($model, 'username', [
        'options' => ['class' => 'mb-3']
    ])->textInput(options: ['onkeyup' => new JsExpression(expression: "if(event.key == 'Enter') { form.submit(); }")]);

    // Filled input
    echo $form->field($model, 'password', [
        'options' => ['class' => 'mb-3']
    ])->passwordInput(options: ['variant' => 'filled', 'onkeyup' => new JsExpression(expression: "if(event.key == 'Enter') { form.submit(); }")]);

    echo $form->field($model, 'remember_me')->checkbox();

    echo Html::submitButton('Iniciar sesión', ['variant' => 'filled']);
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

### DropdownList y List

```php
<?php

// Usando directamente el objeto.
echo DropdownList::widget([
    'items' => [
        '' => '',
        'apple' => 'Apple',
        'apricot' => 'Apricot'
    ], 
    'options' => [
        'class' => 'select',
        'options' => [
            '' => [
                'aria-label' => 'blank'
            ],
            'apple' => ['selected' => true]
        ]
    ]
]);

echo Lists::widget([
    'items' => [
        'Fruits',
        '<md-divider></md-divider>',
        [
            'headline' => 'Apple',
            'options' => [
                'type' => Lists::ITEM_TYPE_BUTTON
            ]
        ]
    ],
]);

// Usando la clase auxiliar Html.
echo \neoacevedo\yii2\material\Html::list([
    'Fruits',
    [
        'label' => '',
        'options' => [
            'type' => 'divider'
        ]
    ],
    [
        'headline' => 'Apple',
        'options' => [
            'type' => 'button'
        ]
    ]
]);

echo \neoacevedo\yii2\material\Html::dropDownList('name', null, [
    '' => '',
    'apple' => 'Apple',
    'apricot' => 'Apricot'
], [
    'class' => 'select',
    'options' => [
        '' => [
            'aria-label' => 'blank'
        ],
        'apple' => ['selected' => true]
    ]
]);
?>
```

Estos componentes web de Material también pueden ser usados de manera directa en el html:

```html
<md-filled-text-field></md-filled-text-field>

<md-card>
...
</md-card>

<md-dialog>
...
</md-dialog>

<md-select>
    <md-select-option value="1">...</md-select-option>
</md-select>

<md-slider></md-slider>
```
