jQuery(function($) {


    $('body').on('click', '.swatch', function() {
        var $swatch = $(this);
        var variationID = $swatch.data('variation-id');

        $.ajax({
            type: 'POST',
            url: ajaxurl, // WordPress AJAX URL
            data: {
                action: 'update_variation',
                variation_id: variationID,
            },
            success: function(response) {
                // Update the product variation details on the page
                // You may need to modify this part based on your design
                // Example: Update the price, SKU, and image.
            },
        });
    });   

	$('#codesigner-texonomy-upload').click(function(e) {
		e.preventDefault();
		var image = wp.media({
			title: 'Upload Image',
			multiple: false // Set to true if you want to allow multiple image uploads
		}).open().on('select', function() {
			var attachment = image.state().get('selection').first().toJSON();
			$('#codesigner-texo-image-preview').attr('src', attachment.url);
			$('#codesigner-texo-image-url').val(attachment.url);
		});
	});

	$('#codesigner-texonomy-update').click(function(e) {
		e.preventDefault();
		var image = wp.media({
			title: 'Upload Image',
			multiple: false // Set to true if you want to allow multiple image uploads
		}).open().on('select', function() {
			var attachment = image.state().get('selection').first().toJSON();
			$('#codesigner-texo-image-preview').attr('src', attachment.url);
			$('#codesigner-texo-image-url').val(attachment.url);
		});
	});

});
