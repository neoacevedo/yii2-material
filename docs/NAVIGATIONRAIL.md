## Navigation Rail

Más info: https://m3.material.io/components/navigation-rail/overview

```php
<?= NavigationRail::widget([
   'options' => [
     'class' => 'align-bottom, // Define la alineación de los elementos
   ]
  'leading' => FloatingActionButton::widget(
          config: [
              'icon' => 'dark_mode',
              'options' => [
                  'lowered' => true,
              ],
          ]
      ),
  'items' => [
     '<p style="pading-bottom: 0.5rem"></p>',
      [
          'icon' => 'group',
          'label' => 'Item 1',
          'options' => [
              'type' => 'link',
              'href' => ['#'],
          ]
      ],
      [
          'icon' => 'manage_accounts',
          'label' => 'Item 2',
          'options' => [
              'type' => 'link',
              'href' => ['#'],
          ]
      ],
      [
          'icon' => 'settings',
          'label' => 'Item 3',
          'options' => [
              'type' => 'link',
              'href' => ['#'],
          ]
      ],
  ],
  'trailing' => IconButton::widget([
      'icon' => 'more_horiz',
      'options' => [
          'variant' => IconButton::TYPE_FILLED_TONAL
      ]
  ])
]) ?>
```
