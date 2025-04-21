## Progress Indicator

```php
<?= ProgressIndicator::widget([
    'type' => ProgressIndicator::MD_PROGRESS_TYPE_CIRCULAR, // o ProgressIndicator::MD_PROGRESS_TYPE_LINEAR
    'options' => [
        'value' => '0.75'
    ]
]) ?>
```

Este componente web de Material también puede ser usado de manera directa en el html:

<md-linear-progress value='0.75'></md-linear-progress>
<md-circular-progress indeterminate></md-circular-progress>
