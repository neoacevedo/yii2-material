## Floating Action Button

```php
<?= FloatingActionButton::widget(
    config: [
        'icon' => 'dark_mode',
        'options' => [
            'lowered' => true,
            'aria-label' => 'Dark Mode',
            'onclick' => new JsExpression(expression: "toggleTheme();")
        ],
    ]
) ?>

// Branded
<?= FloatingActionButton::widget(
    config: [
        'icon' => '<svg slot="icon" viewBox="0 0 36 36">
                        <path fill="#34A853" d="M16 16v14h4V20z"></path>
                        <path fill="#4285F4" d="M30 16H20l-4 4h14z"></path>
                        <path fill="#FBBC05" d="M6 16v4h10l4-4z"></path>
                        <path fill="#EA4335" d="M20 16V6h-4v14z"></path>
                        <path fill="none" d="M0 0h36v36H0z"></path>
                    </svg>',
        'branded' => true,
        'options' => [
            'size' => 'small',
            'aria-label' => 'Add'
        ],
    ]
) ?>
```

Este componente web de Material también puede ser usado de manera directa en el html:

```html
<md-fab lowered aria-label="Dark Mode" onclick="toggleTheme();">
  <md-icon slot="icon">dark_mode</md-icon>
</md-fab>

<md-branded-fab size="small" aria-label="Add">
  <svg slot="icon" viewBox="0 0 36 36">
    <path fill="#34A853" d="M16 16v14h4V20z"></path>
    <path fill="#4285F4" d="M30 16H20l-4 4h14z"></path>
    <path fill="#FBBC05" d="M6 16v4h10l4-4z"></path>
    <path fill="#EA4335" d="M20 16V6h-4v14z"></path>
    <path fill="none" d="M0 0h36v36H0z"></path>
  </svg>
</md-branded-fab>
```