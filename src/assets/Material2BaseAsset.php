<?php

namespace neoacevedo\yii2\material3\assets;

use yii\web\AssetBundle;

class Material2BaseAsset extends AssetBundle
{
    public $sourcePath = "@npm/material--base/dist";

    public $js = [
        'mdc.base.min.js'
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}