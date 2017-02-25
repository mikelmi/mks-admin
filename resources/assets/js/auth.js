require('./base');

$(document).ready(function() {
    //apply custom checkboxes and radios
    if (!$('body').hasClass('materialized')) {
        $('.form-check-label').each(function() {
            var label = $(this);
            var input = label.children('.form-check-input');

            label.addClass('custom-control ' + (input.is(':radio') ? 'custom-radio' : 'custom-checkbox'));

            input.addClass('custom-control-input')
                .after('<span class="custom-control-indicator"></span>');
        });
    }
});
