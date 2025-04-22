Yii2 Material 3
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
php composer.phar require --prefer-dist neoacevedo/yii2-material3
```

o agregue

```js
"neoacevedo/yii2-material3": "*"
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

- [Card](docs/CARD.md)
- [Checkbox](docs/CHECKBOX.md)
- [Icon](docs/ICONBUTTON.md)
- [ActiveForm y ActiveField](docs/ACTIVEFORM.md)
- [Dialog](docs/DIALOG.md)
- [ListTile](docs/LISTTILE.md) 
- [ProgressIndicator](docs/PROGRESSINDICATOR.md) 
- [Radio](docs/RADIO.md)
