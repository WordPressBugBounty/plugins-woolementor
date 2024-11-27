let codesigner_modal = (show = true) => {
    if (show) {
        jQuery("#codesigner-modal").show();
    } else {
        jQuery("#codesigner-modal").hide();
    }
};

jQuery(function ($) {
    // add to wishlist
    $(document).on("click", ".ajax_add_to_wish", function (e) {
        e.preventDefault();
        var $this = $(this);
        var $product_id = $this.data("product_id");

        $.ajax({
            url: CODESIGNER.ajaxurl,
            data: {
                action: "add-to-wish",
                _wpnonce: CODESIGNER._wpnonce,
                product_id: $product_id,
            },
            type: "POST",
            dataType: "JSON",
            success: function (resp) {
                if (resp.action == "added") {
                    $this.addClass("fav-item");
                } else {
                    $this.removeClass("fav-item");
                }
            },
            error: function (resp) {
                console.log(resp);
            },
        });
    });

    // remove from wishlist
    $(document).on("click", ".ajax_remove_from_wish", function (e) {
        e.preventDefault();
        var $this = $(this);
        var $product_id = $this.data("product_id");

        $.ajax({
            url: CODESIGNER.ajaxurl,
            data: {
                action: "add-to-wish",
                _wpnonce: CODESIGNER._wpnonce,
                product_id: $product_id,
            },
            type: "POST",
            dataType: "JSON",
            success: function (resp) {
                if (resp.action == "removed") {
                    $this.closest("tr").remove();
                }
            },
            error: function (resp) {
                console.log(resp);
            },
        });
    });

    // multiple-product-add-to-cart
    $(".multiple-product-add-to-cart").on("submit", function (e) {
        e.preventDefault();
        var $formData = $(this).serializeArray();
        $.ajax({
            url: CODESIGNER.ajaxurl,
            data: $formData,
            type: "POST",
            dataType: "JSON",
            success: function (resp) {
                if (resp.status == 1) {
                    $(".multiselect-view-cart").show();
                }
            },
            error: function (resp) {
                console.log(resp);
            },
        });
    });
});
