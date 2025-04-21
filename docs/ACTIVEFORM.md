## Material3ActiveForm y Material3ActiveField

Material3ActiveForm extiende de ActivForm, por lo que tiene sus mismas características, con un adicional de inicio de reglas de validación para los input text de tipo material component.

Material3ActiveField renderiza los componentes `md-text-field` o sus variantes.

Dada la limitancia en el evento Enter de los componentes text-field de Material, se requiere que se incluya el evento `onkeyup` en cada text-field para enviar el formulario al presionar  la tecla Enter.

```php
<?php
    /**
     * @var Material3ActiveForm
     */
    $form = Material3ActiveForm::begin([
        'id' => 'form'

    ]);

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

    Material3ActiveForm::end();
?>
```