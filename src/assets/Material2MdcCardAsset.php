<?php

namespace neoacevedo\yii2\material3\assets;

use yii\web\AssetBundle;

class Material2MdcCardAsset extends AssetBundle
{
    public $sourcePath = '@npm/material--card/dist';

    public $css = [
        'mdc.card.min.css'
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}