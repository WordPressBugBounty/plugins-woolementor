jQuery(function ($) {
    function togglePaymentOptions() {
        let checkbox = $("#cd_enable_partial_payment");
        let paymentOptions = $("#partial_payment_options");

        if (checkbox.is(":checked")) {
            paymentOptions.show("slow");
        } else {
            paymentOptions.hide("slow");
        }
    }

    $("#cd_enable_partial_payment").on("change", function () {
        togglePaymentOptions();
    });

    function togglePartialAmountType() {
        let percentagePayment = $("#cd_percentage_payment");
        let fixedPayment = $("#cd_fixed_payment");
        let customPayment = $("#cd_custom_payment");

        let paymentType = $("#cd_partial_amount_type").val();

        if (paymentType === "percentage") {
            fixedPayment.hide("slow");
            customPayment.hide("slow");
            percentagePayment.show("slow");
        } else if (paymentType === "fixed") {
            percentagePayment.hide("slow");
            customPayment.hide("slow");
            fixedPayment.show("slow");
        } else {
            percentagePayment.hide("slow");
            fixedPayment.hide("slow");
            customPayment.show("slow");
        }
    }

    $("#cd_partial_amount_type").on("change", function () {
        togglePartialAmountType();
    });

    togglePaymentOptions();
    togglePartialAmountType();

    // hide original order total in order edit page
    $(document).ready(function () {
        $(
            ".wp-admin.woocommerce-feature-enabled-product-block-editor #woocommerce-order-items .inside .wc-order-totals:first tbody tr:last-child"
        ).hide();
    });
});
