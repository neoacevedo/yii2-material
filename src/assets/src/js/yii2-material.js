
/**
 * @copyright neoacevedo, 2025
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

let materialInitForm = function (id, errorClass) {

};

(function ($) {
    materialInitForm = function () {
        var controls = ['md-outlined-text-field', 'md-filled-text-field', 'md-outlined-select', 'md-filled-select'],
            validControls = controls.join(','),
            errorControls = '.has-error ' + controls.join(',.has-error '),
            successControls = '.has-success ' + controls.join(',.has-success '),
            resetControls = function ($form) {
                $form.find(validControls).removeClass('has-success has-error');
                $form.find(errorControls).removeAttr('error');
                $form.find(errorControls).removeAttr('error-text');
            };
        $('form').on('afterValidateAttribute', function (form, field, messages) {
            var $form = $(this);
            if ($form.find('.has-error').length || $form.find('.has-success').length) {
                $form.find('#' + field.id).attr('error', true);
                $form.find('#' + field.id).attr('error-text', messages[0]);
                $form.find(successControls).removeAttr('error');
            }
        }).on('reset', function () {
            var $form = $(this);
            setTimeout(function () {
                resetControls($form);
            }, 100);
        });

    };

})(window.jQuery);
