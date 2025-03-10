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

use neoacevedo\yii2\material\Html;
use yii\base\Widget;

/**
 * Snackbar es la clase que renderiza el componente web Snackbar de Material 3.
 * 
 * Ejemplo:
 * 
 * ```php
 * <?php
 * echo Snackbar::widget([
 *     'id' => $this->id,
 *     'supportingText' => 'Supporting text',
 *     'options' => [
 *         'show-close-icon' => 'true', // Muestra el botón de cerrar el snackbar. Si se omite o se establece en 'false', no se mostrará el botón
 *         'duration' => 3, 
 *     ],
 *     'action' => '<button>Botón</button>', // O un botón Html::button()
 * ]);
 * ```
 */
class Snackbar extends Widget
{
    const TYPE_LEADING = 'leading';
    const TYPE_STACKED = 'stacked';

    /**
     * Este es el botón de acción que contiene el componente.
     * @see https://m3.material.io/components/snackbar/guidelines#ff603b1b-7efc-4930-bb6f-584a6455819c
     * @var string
     */
    public string $action = '';

    /**
     * @var array los atributos HTML (pares de valor de nombre) para la etiqueta contenedor de campo.      
     * Los valores serán codificados HTML usando [[Html::encode()]].
     * Si un valor es `null`, el atributo correspondiente no se entregará.
     * Se reconocen las siguientes opciones especiales: 
     *
     * - `show-close-icon`: cuando renderizar o no el botón de cererar. El valor booleano debe ser establecido como string para que tenga efecto.
     *      Si es omitido, el botón no será mostrado.
     * - `duration`: el tiempo en segundos en que el snackbar estará visible. Por defecto, el snackbar estará visible un máximo de 3 segundos.
     *
     * @see [\yii\helpers\Html::renderTagAttributes()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     * @see https://material-web.dev/components/dialog/#properties for dialog properties.
     */
    public array $options = [];

    /**
     * The text to be displayed in the snackbar.
     * @var string
     */
    public string $supportingText;

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        $this->options = array_merge([
            'id' => $this->id,
        ], $this->options);

        $html = Html::beginTag('md-snackbar', $this->options);

        $html .= Html::tag('div', $this->supportingText, ['slot' => 'supporting-text']) . "\n";
        $html .= $this->renderActionButton() . "\n";

        $html .= Html::endTag('md-snackbar') . "\n";

        echo $html;
    }

    /**
     * Renderiza el botón de acción.
     * @return string|null
     */
    protected function renderActionButton(): string|null
    {
        if (!$this->action) {
            return null;
        }

        return Html::tag(name: 'div', content: $this->action, options: ['slot' => 'action']);
    }

}