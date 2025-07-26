# Snackbar

La clase `Snackbar` renderiza el componente web [Snackbar de Material 3](https://m3.material.io/components/snackbar). Este widget permite mostrar mensajes breves a los usuarios con una acción opcional.

---

## Propiedades Públicas

A continuación se detallan las propiedades configurables del widget.

### `action`
Define el botón de acción que se muestra en el snackbar.

- **Tipo:** `string`
- **Por defecto:** `''` (vacío)
- **Detalles:** Puede ser una cadena de texto HTML, como un botón creado con `Html::button()`.
- **Referencia:** [Material 3 Snackbar Guidelines](https://m3.material.io/components/snackbar/guidelines#ff603b1b-7efc-4930-bb6f-584a6455819c)

```php
'action' => '<button>Reintentar</button>',
```

o

```php
'action' => \neoacevedo\yii2\material\Html::button('Reintentar', ['class' => 'my-class']),
```

<br>

### `options`

Un array con los atributos HTML para la etiqueta contenedora del widget (`<md-snackbar>`).

  - **Tipo:** `array`
  - **Por defecto:** `[]`
  - **Detalles:** Permite configurar el comportamiento y la apariencia del snackbar a través de opciones especiales. Los valores son codificados en HTML. Si un valor es `null`, el atributo no se renderiza.

#### Opciones Especiales de `options`

  - `show-close-icon`: **(string)** Controla la visibilidad del ícono para cerrar el snackbar. Debe ser un string `'true'` o `'false'`. Si se omite, el botón no se muestra.
  - `duration`: **(int)** El tiempo en segundos que el snackbar permanecerá visible. El valor por defecto es de 3 segundos.
  - `disable-auto-hide`: **(string)** Inactiva la visibilidad del snackbar. Por defecto el snackbar se oculta después de 3 segundos o del valor configurado en `show-close-icon`. Agregando este parámetro, el snackbar no se ocultará de modo automático. Esto es útil cuando se tiene un botón de acción que requiera una respuestá del usuario.

<br>

### `supportingText`

El texto principal que se mostrará dentro del snackbar.

  - **Tipo:** `string`
  - **Requerido:** Sí.
  - **Detalles:** Este es el mensaje principal para el usuario.

-----

## Ejemplo de Uso en PHP

A continuación se muestra un ejemplo básico de cómo implementar el widget `Snackbar` en una vista de Yii2.

```php
<?php

use neoacevedo\yii2\material\widgets\Snackbar;

echo Snackbar::widget([
    'id' => 'my-snackbar',
    'supportingText' => 'Este es un mensaje de notificación.',
    'options' => [
        'show-close-icon' => 'true', // Muestra el botón de cerrar
        'duration' => 5,             // Visible por 5 segundos
    ],
    'action' => '<md-text-button>Acción</md-text-button>', // O un botón Html::button() o con el componente directo Button::widget([...])
]);
?>
```

Este componente web de Material también puede ser usado de manera directa en el html:

```html
<md-snackbar id="snackbar0">
    <div slot="supporting-text">Mensaje automático al cargar la página</div>
</md-snackbar>

<md-snackbar id="snackbar1" show-close-icon="">
    <div slot="supporting-text">Mensaje al hacer clic en el botón de cerrar</div>
</md-snackbar>

<md-snackbar id="snackbar2">
    <div slot="supporting-text">Mensaje que se oculta manualmente</div>
</md-snackbar>
```

-----

## Ejemplo de Uso en JavaScript

Puedes controlar la visibilidad del snackbar desde JavaScript usando los métodos públicos `showSnackbar()` y `hide()`:

```js
// Se mostrará el primer snackbar solo al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    let snackbar = document.querySelector('#snackbar0');
    snackbar.showSnackbar();
});

// Mostrar el segundo snackbar al hacer clic en un botón de cerrar personalizado
snackbarCloseBtn?.addEventListener('click', () => {
    let snackbar = document.querySelector('#snackbar1');
    snackbar.showSnackbar();
});

// Ocultar manualmente el tercer snackbar
document.getElementById('snackbar2').hide();
```

-----

## Enlaces útiles

- [Material 3 Snackbar Guidelines](https://m3.material.io/components/snackbar/guidelines)
- [Documentación de Yii2 Widgets](https://www.yiiframework.com/doc/api/2.0/yii-base-widget)
- [Material Web Snackbar](https://material-web.dev/components/snackbar/)

-----

## Licencia

Este programa es software libre distribuido bajo la [Licencia Pública General GNU v3](http://www.gnu.org/licenses/).

-----
