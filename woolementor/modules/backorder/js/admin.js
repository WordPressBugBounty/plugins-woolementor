jQuery(function($){

    function backorderFields() {
        if ($("#_manage_stock").is(":checked")) {
            var backorderAllowed = $('input[name="_backorders"]:checked').val();
            if ( backorderAllowed == 'yes' || backorderAllowed == 'notify' ) {
                $('.cd_backorder_time_field').show();
            } 
            else {
                $('.cd_backorder_time_field').hide();
            }
        }
        else{
            var stockStatus = $('#_stock_status').val();

            if ( stockStatus == 'onbackorder' ) {
                $('.cd_backorder_time_field').show();
            } 
            else {
                $('.cd_backorder_time_field').hide();
            } 
        }
    }

    jQuery(document).ready(function($) {
        backorderFields();
        $("#_stock_status").on("change", function() {
            backorderFields();
        });
        $('input[name="_backorders"]').on("change", function() {
            backorderFields()
        });
        $('#_manage_stock').click(function() {
            backorderFields();
        });
    });
})