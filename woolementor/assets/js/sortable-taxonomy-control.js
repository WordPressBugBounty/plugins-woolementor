jQuery(function($){
	elementor.hooks.addAction( 'panel/open_editor/widget', function( panel, model, view ) {

		function sortable_value () {
			$('.wl-sortable-input').val('');		
			var values = $(".wl-sortable-control-panel li input.wl-sortable-checkbox-field").map(function() {
				if($(this).prop('checked') === true) {
					return $(this).attr('value');
		        }
			}).get();

			$('.wl-sortable-input').val(values).trigger('input');
		}
		
		$('.wl-sortable-control-panel').sortable({
			update: function( event, ui ) {
				sortable_value();
			}
		});

		$(document).on( 'change', '.wl-sortable-checkbox-field', function (e) {
			sortable_value();
		} )
	} );
});