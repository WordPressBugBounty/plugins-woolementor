jQuery(document).ready(function($) {
    function adjustIndexes(wrapper) {
        wrapper.find('.cd-single-discount-rule').each(function(index) {
            var inputs = $(this).find('input');
            inputs.each(function() {
                console.log( index );
                var currentName = $(this).attr('name');
                currentName = currentName.replace(/\[.*?\]/, '[' + index + ']');
                $(this).attr('name', currentName);
            });
        });
    }

    $(document).on('click', '.cd-add-row', function() {
        var closestRow = $(this).closest('.cd-single-discount-rule');
        var newRow = closestRow.clone();
        newRow.find('input').val('');
        $(this).closest('.cd-bpd-wrapper').append(newRow);
        var wrapper = $(this).closest('.cd-bpd-wrapper');
        adjustIndexes(wrapper);
    });

    $(document).on('click', '.cd-remove-row', function() {
        var rows = $('.cd-single-discount-rule');
        var wrapper = $(this).closest('.cd-bpd-wrapper');
        if (rows.length > 1) {
            $(this).closest('.cd-single-discount-rule').remove();
            adjustIndexes(wrapper);
        }
    });
});