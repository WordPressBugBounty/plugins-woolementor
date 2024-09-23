jQuery(function($){
	elementor.hooks.addAction( 'panel/open_editor/widget', function( panel, model, view ) {
		$('.wl-sortable-control-panel').sortable({
			update: function( event, ui ) {
				$('.wl-sortable-input').val('');		
				var values = $(".wl-sortable-control-panel li input").map(function(){return $(this).val();}).get();
				$('.wl-sortable-input').val(values).trigger('input');		
			}
		});
	} );
});