jQuery(function ($) {
    $(document).ready(function () {
        function togglePaymentAmount() {
            let paymentAmountBlock = $(".cd_partial_payment_amount_block");
            let customAmount = $(
                ".cd_partial_payment_amount_block .cd_custom_amount"
            );
            let partialAmount = $(
                ".cd_partial_payment_amount_block .cd_partial_amount"
            );
            let radioBtn = $(".cd_radio_block input[type=radio]:checked");

            if (radioBtn.val() === "full") {
                paymentAmountBlock.hide("slow");
            } else if (radioBtn.val() === "custom") {
                paymentAmountBlock.show("slow");
                partialAmount.hide("slow");
                customAmount.show("slow");
            } else {
                paymentAmountBlock.show("slow");
                customAmount.hide("slow");
                partialAmount.show("slow");
            }
        }

        togglePaymentAmount();

        $(".cd_radio_block input[type=radio]").on("change", function () {
            togglePaymentAmount();
        });

        // if ($(".order-total.cd-order-total")) {
        //     $(".order-total").hide();
        //     $(".order-total.cd-order-total").show();
        // } else {
        //     $(".order-total").show();
        // }
    });
});
