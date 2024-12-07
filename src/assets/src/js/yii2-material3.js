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


