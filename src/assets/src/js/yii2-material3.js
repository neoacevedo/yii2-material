
/**
 * @copyright Copyright (c) 2024 neoacevedo
 * @subpackage yii2-material3
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

let m3InitForm = function (id, errorClass) {

};

(function ($) {
    m3InitForm = function (id, errorClass) {
        customElements.whenDefined('md-outlined-text-field').then(() => {
            resetControls = function ($form) {
                let textFields = $form.find('md-outlined-text-field, md-filled-text-field');

                textFields.map((index) => {
                    let shadowRoot = textFields[index].shadowRoot;
                    let outlinedFields = $(shadowRoot).find('md-outlined-field, md-filled-field');
                    outlinedFields.map((i) => {
                        let innerShadowRoot = outlinedFields[i].shadowRoot;
                        $(innerShadowRoot).find('.field').removeClass('error');
                    });
                });
            };

            $(id).on('afterValidateAttribute', function () {
                let $form = $(this);
                resetControls($form);
                if ($form.find(errorClass).length) {
                    let textFields = $form.find(errorClass).find('md-outlined-text-field, md-filled-text-field');
                    textFields.map((index) => {
                        let shadowRoot = textFields[index].shadowRoot;
                        let outlinedFields = $(shadowRoot).find('md-outlined-field, md-filled-field');
                        outlinedFields.map((i) => {
                            let innerShadowRoot = outlinedFields[i].shadowRoot;
                            $(innerShadowRoot).find('.field').addClass('error');
                        });
                    });
                }
            }).on('reset', function () {
                var $form = $(this);
                setTimeout(function () {
                    resetControls($form);
                }, 100);
            });
        })

    };

})(window.jQuery);


