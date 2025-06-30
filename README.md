Yii2 Material
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
php composer.phar require --prefer-dist neoacevedo/yii2-material
```

o agregue

```js
"neoacevedo/yii2-material": "*"
```

a la sección require de su archivo `composer.json`.

Uso
----

Incluya antes del cierre de la etiqueta 'body' de su plantilla principal lo siguiente:

```php
<?= MaterialAsset::publishMaterialScripts() ?>
```

> Los data-* atributos programados no funcionan en Material Design Components para la web, por lo que se tendrán que programar los elementos que tengan estos atributos de manera separada.

Componentes
---

- [ActiveForm y ActiveField](docs/ACTIVEFORM.md)
- [Button](docs/BUTTON.md)
- [Card](docs/CARD.md)
- [Checkbox](docs/CHECKBOX.md)
- [Dialog](docs/DIALOG.md)
- [Floating Action Button](docs/FAB.md)
- [Icon Button](docs/ICONBUTTON.md)
- [ListTile](docs/LISTTILE.md) 
- [Menu](docs/MENU.md)
- [ProgressIndicator](docs/PROGRESSINDICATOR.md) 
- [Radio](docs/RADIO.md)
- [SnackBar](docs/SNACKBAR.md)
