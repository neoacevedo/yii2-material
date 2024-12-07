<?php

namespace neoacevedo\yii2\material3\assets;

use yii\web\AssetBundle;

class MaterialRippleAsset extends AssetBundle
{
    public $sourcePath = "@npm/material--ripple/dist";

    public $css = [
        'mdc.ripple.min.css'
    ];

    public $js = [
        'mdc.ripple.min.js'
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}