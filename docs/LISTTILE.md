## DropdownList y ListTile

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

echo ListTile::widget([
    'items' => [
        'Fruits',
        '<md-divider></md-divider>',
        [
            'headline' => 'Apple',
            'options' => [
                'type' => ListTile::ITEM_TYPE_BUTTON
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
<md-select>
    <md-select-option value="1">...</md-select-option>
</md-select>

<md-list>
    <md-list-item>...</md-list-item>
</md-list>
```