jQuery(document).ready(function($) {
    $('input[name="cd_selected_currency"]').change(function() {
        var currency   = $('input[name="cd_selected_currency"]:checked').val();
		$.ajax({
			url: CODESIGNER.ajaxurl,
			data: { 'action' : 'cd-change-currency', _wpnonce : CODESIGNER._wpnonce, currency : currency },
			type: 'POST',
			dataType: 'JSON',
			success: function( resp ) {
                location.reload();
			},
			error: function( error ) {
				console.log(error);
			}
		})
    });
});