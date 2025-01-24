Yii2 Material 3
============

<p align="center">
<svg width="100" height="100" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" fill="#757575" r="12"/><path d="m3.6 3.6h16.8v16.8h-16.8z" fill="#bdbdbd"/><path d="m20.4 3.6-8.4 16.8-8.4-16.8z" fill="#fff"/><path d="m0 0h24v24h-24z" fill="none"/></svg>
</p>

Esta es una extensión primaria para [Yii framework 2.0](https://www.yiiframework.com). Encapsula componentes de [Material Design](https://m3.material.io/) en términos de Widgets Yii.

**NOTA**: Material 3 no tiene los componentes `Card` ni `Snackbar`, así que se han adaptado los componentes de la versión 2 para intentar seguir los lineamientos de la versión 3.

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
.demo-card {
  width: 320px;
  margin: 48px 0;
}

/* Card */
.mdc-typography--headline6 {
    font-size: 1.25rem;
    font-weight: 500;
    letter-spacing: .0125em;
}

.mdc-typography--subtitle2 {
    font-size: .875rem;
    line-height: 1.375rem;
    font-weight: 500;
    letter-spacing: .0071428571em;
}

.mdc-card-body {
    padding: 8px 1rem;
}

.mdc-card__body--typography {
    line-height: 1.25rem;
    font-weight: 400;
}
CSS;

$this->registerCss($css);
?>
<main class="row">
    <?php
    \neoacevedo\yii2\material3\widgets\MaterialCard::begin([
        'options' => [
            'class' => 'demo-card'
        ],
        'titleOptions' => [
            'class' => 'mdc-typography--headline6'
        ],
        'subtitleOptions' => [
            'class' => 'mdc-typography--subtitle2'
        ],
        'title' => 'Our Changing Planet',
        'subtitle' => 'by Kurt Wagner',
        'mediaSrc' => 'https://material-components.github.io/material-components-web-catalog/static/media/photos/3x2/2.jpg',
        'actions' => [
            'icons' => [
                Html::iconButton(['icon' => 'dictionary']),
                Html::iconButton(['icon' => 'bookmark'])
            ]
        ]
    ]);
    ?>
    <div class="mdc-card__body mdc-card__body--typography">Visit ten places on our planet that are
        undergoing the biggest changes today.</div>
    <?php
    \neoacevedo\yii2\material3\widgets\MaterialCard::end();
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

echo $form->field($model, 'remember_me')->checkbox

?>
```