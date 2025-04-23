
/**
 * @preserve
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
 * @endpreserve
 */

let materialInitForm = function (id, errorClass) {

};

function closeSnackbar(id) {
    const snackbar = new mdc.snackbar.MDCSnackbar(document.querySelector(id));
    snackbar.open();
    setTimeout(() => {
        snackbar.close();
    }, 3000);
}

(function ($) {
    materialInitForm = function (id, errorClass) {
        let elements = 'md-outlined-text-field, md-filled-text-field, md-outlined-select, md-filled-select';
        Promise.all([
            customElements.whenDefined('md-outlined-text-field'),
            customElements.whenDefined('md-filled-text-field'),
            customElements.whenDefined('md-outlined-select'),
            customElements.whenDefined('md-filled-select')
        ])
            .then(() => {
                resetControls = function ($form) {
                    let fields = $form.find(elements);

                    fields.map((index) => {
                        fields[index].removeAttribute('error');
                        let shadowRoot = fields[index].shadowRoot;
                        let outlinedFields = $(shadowRoot).find(elements);
                        outlinedFields.map((i) => {
                            let innerShadowRoot = outlinedFields[i].shadowRoot;
                            $(innerShadowRoot).find('.field').removeClass('error');
                        });
                    });
                };

                $(id).on('afterValidateAttribute', function (event, attribute, messages) {
                    let $form = $(this);
                    resetControls($form);
                    if ($form.find(errorClass).length) {
                        let fields = $form.find(errorClass).find(elements);
                        fields.map((index) => {
                            fields[index].setAttribute('error-text', messages[0]);
                            fields[index].setAttribute('error', '');
                            let shadowRoot = fields[index].shadowRoot;
                            let outlinedFields = $(shadowRoot).find(elements);
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


