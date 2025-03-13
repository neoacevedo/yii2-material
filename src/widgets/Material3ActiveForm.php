<?php

/**
 * @copyright Copyright (c) 2024 neoacevedo
 * @subpackage yii2-material
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace neoacevedo\yii2\material\widgets;

use neoacevedo\yii2\material\assets\MaterialAsset;
use yii\widgets\ActiveForm;

/**
 * Material3ActiveForm hereda de [[\yii\widgets\ActiveForm]] para generar las etiquetas de Material Design Components.
 */
class Material3ActiveForm extends ActiveForm
{

    /**
     * @var string the CSS class that is added to a field container when the associated attribute has validation error.
     */
    public $errorCssClass = 'has-error';

    /**
     * @inheritDoc 
     */
    public $fieldClass = Material3ActiveField::class;

    /**
     * This registers the necessary JavaScript code.
     * @since 2.0.12
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        MaterialAsset::register($view);

        $js = "materialInitForm('#{$this->options['id']}', '.{$this->errorCssClass}');";
        $view->registerJs($js, \yii\web\View::POS_END);

        parent::registerClientScript();
    }
}
