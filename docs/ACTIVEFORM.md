## Material3ActiveForm y Material3ActiveField

```php
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