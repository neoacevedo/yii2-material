## Menu

```php
<?php
echo Menu::widget([
    'id' => 'usage-smenu',
    'options' => [
        'anchor' => 'submenu-anchor', 
        'positioning' => Menu::POSITION_FIXED, 
        'has-overflow' => true
    ],
    'items' => [
        [
            'headline' => 'Fruits with A',
            'trailing' => 'arrow_right',
            'items' => [
                [
                    'headline' => 'Appricot'
                ],
                [
                    'headline' => 'Avocado',
                ],
                [
                    'headline' => 'Apples',
                    'leading' => 'arrow_left',
                    'options' => [
                        'menu-corner' => 'start-end',
                        'anchor-corner' => 'start-start'
                    ],
                    'items' => [
                        [
                            'headline' => 'Fuji'
                        ],
                        [
                            'headline' => 'Granny Smith',
                        ],
                        [
                            'headline' => 'Red Delicious'
                        ]
                    ]
                ]
            ]
        ],
        [
            'headline' => 'Banana'
        ],
        [
            'headline' => 'Cucumber'
        ]
    ],
]);
?>
```

Este componente web de Material también puede ser usado de manera directa en el html:

<md-menu>
...
</md-menu>
