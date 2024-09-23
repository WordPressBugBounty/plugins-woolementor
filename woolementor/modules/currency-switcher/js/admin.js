jQuery(document).ready(function($) {
    function adjustIndexes(wrapper) {
        wrapper.find('.cd-single-currency').each(function(index) {
            var inputs = $(this).find('input, select');
            inputs.each(function() {
                var currentName = $(this).attr('name');
                currentName = currentName.replace(/\[.*?\]/, '[' + index + ']');
                $(this).attr('name', currentName);
            });
        });
    }
    
    $(document).on('click', '.cd-cs-add-row', function() {
        var closestRow = $(this).closest('.cd-single-currency');
        var newRow = closestRow.clone();
        newRow.find('input').val('');
        newRow.find('div').html('<button class="cd-cs-upload-image cd-cs-button">Uplaod Flag</button>');
        $(this).closest('.cd-cs-wrapper').append(newRow);
        var wrapper = $(this).closest('.cd-cs-wrapper');
        adjustIndexes(wrapper);
    });

    $(document).on('click', '.cd-cs-remove-row', function() {
        var rows = $('.cd-single-currency');
        var wrapper = $(this).closest('.cd-cs-wrapper');
        if (rows.length > 1) {
            $(this).closest('.cd-single-currency').remove();
            adjustIndexes(wrapper);
        }
    });

    $(document).on('click', '.cd-cs-upload-image', function(e) {
        e.preventDefault();
        var imageUploader = wp.media({
            title: 'Upload Currency Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        var currentButton = $(this);

        imageUploader.on('select', function() {
            var attachment      = imageUploader.state().get('selection').first().toJSON();
            var imageInput      = currentButton.closest('.cd-single-currency').find('.cd-cs-image');
            var imagePreview    = currentButton.closest('.cd-single-currency').find('.cd-cs-preview-image');
            var newImage        = document.createElement('img');
            newImage.src        = attachment.url;

            imageInput.val(attachment.id);
            newImage.classList.add('cd-cs-upload-image');
            imagePreview.empty().append(newImage);

        });

        imageUploader.open();
    });
});