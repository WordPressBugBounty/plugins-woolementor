jQuery(function($){

    function preorderFields() {

        var stockStatus = $('#_stock_status').val();

        if ( stockStatus == 'pre_order' ) {
            $('.cd_preorder_time_field').show();
        } 
        else {
            $('.cd_preorder_time_field').hide();
        } 
    }

    jQuery(document).ready(function($) {
        preorderFields();
        $("#_stock_status").on("change", function() {
            preorderFields();
        });
    });
})