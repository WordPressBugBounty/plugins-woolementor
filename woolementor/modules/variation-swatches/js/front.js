jQuery(function ($) {
    // disable add to cart button of add to cart widget
    if ($(".wl-atc-button-area .variation_id").val() == 0) {
        $(".wl-atc-button-area .single_add_to_cart_button").prop(
            "disabled",
            true
        );
    }

    function vsReset( productID ) {

        $(`.codesigner-vs-radio[data-product-id="${productID}"]`).prop("disabled", false);
        $(`.codesigner-vs-radio[data-product-id="${productID}"]`).prop("checked", false);
    
        $(".wl-atc-button-area .single_add_to_cart_button").prop(
            "disabled",
            true
        );

        $(".wl-atc-button-area .variation_id").val(0);
        $(`.cd-vs-id[data-product-id="${productID}"]`).val(0);
    }

    $(document).ready(function () {

        $(document).on(
            "click",
            '.cd-variation-swatches-form input[type="checkbox"]',
            function () {

                var form                = $(this).closest(".cd-variation-swatches-wrapper");
                var wrapper             = $(this).closest('.codesigner-vs-wrapper');
                var variationObj        = form.data("variations");
                var productId           = form.data("product-id");
                var attributeKeys       = variationObj.attributes.keys;
                var options             = variationObj.attributes.options;
                var variations          = variationObj.variations;
                var matchValArray       = [];
                var matchAttrArray      = [];
                var finalAllMatch       = [];
                var alreadyMatchedAttr  = [];
                let sliceIndex          = 0;

                wrapper.find('input[type="checkbox"]').not(this).prop('checked', false);

                attributeKeys.forEach((attribute) => {
                    var checkedRadios = $(`.${attribute} input[type="checkbox"]:checked[data-product-id="${productId}"]`);
        
                    checkedRadios.each(function() {
                        var attrValue   = $(this).val();
                        var attrName    = $(this).data("attribute_name");
            
                        if (attrValue) {
                            matchValArray.push(attrValue);
                        }
                        if (attrName) {
                            matchAttrArray.push(attrName);
                        }
                    });
                });

                Object.entries( attributeKeys ).forEach( () => {
                    const compAttr  = matchAttrArray[sliceIndex];
                    const compVal   = matchValArray.slice( 0, sliceIndex ).concat( matchValArray.slice( sliceIndex + 1 ) );

                    if ( compAttr != undefined ) {
                        Object.entries( variations ).forEach(
                            ( [id, variation] ) => {
                                var attributes = variation.attributes;
                                if ( compVal.every( ( val ) => Object.values( attributes ).includes( val ) ) ) {
                                    if ( !finalAllMatch[compAttr] ) {
                                        finalAllMatch[compAttr] = [];
                                        alreadyMatchedAttr.push(compAttr);
                                    }
                                    if ( !finalAllMatch[compAttr].includes( attributes[compAttr] ) ) {
                                        finalAllMatch[compAttr].push( attributes[compAttr] );
                                    }
                                }
                            }
                        );
                    }
                    sliceIndex++;
                });

                var missingAttr = attributeKeys.filter( ( key ) => !alreadyMatchedAttr.includes( key ) );

                if (missingAttr) {
                    missingAttr.forEach( ( missingKey, index ) => {
                        Object.entries(variations).forEach(
                            ( [id, variation] ) => {
                                var attributes = variation.attributes;
                                if ( matchValArray.every( ( val ) => Object.values( attributes ).includes( val ) ) ) {
                                    if ( !finalAllMatch[missingKey] ) {
                                        finalAllMatch[missingKey] = [];
                                    }
                                    if ( !finalAllMatch[missingKey].includes( attributes[missingKey] ) ) {
                                        finalAllMatch[missingKey].push( attributes[missingKey] );
                                    }
                                }
                            }
                        );
                    });
                }

                vsReset( productId );

                Object.entries(options).forEach(([attrName, values], index) => {
                    values.forEach((termName) => {
                        var fieldId = "codesigner_vs_" + termName + "_" + productId;

                        if ( finalAllMatch[attrName] && !finalAllMatch[attrName].includes( termName ) ) {
                            $("#" + fieldId).prop("disabled", true);
                        }
                        if (matchValArray.includes(termName)) {
                            $("#" + fieldId).prop("checked", true);
                        }
                    });
                });

                // update variation id
                if ( matchValArray.length == attributeKeys.length ) {
                    Object.entries( variations ).forEach(([id, variation]) => {
                        var attributes  = variation.attributes; 
                        var price_html  = variation.price_html; 

                        if ( matchValArray.every( ( val ) => Object.values( attributes ).includes( val ) ) ) {
                            $(".wl-atc-button-area .variation_id").val( id );
                            $(this).parents(".product").find(".cd-vs-id").val( id );
                            $(this).parents(".product").find(".price").html( price_html );
                            $(".wl-atc-button-area .single_add_to_cart_button").prop("disabled", false);
                        }
                    });
                }
            }
        );
        //archive page add to cart
        $(document).on("click", ".wl-shop .product_type_variable", function (e) {
            e.preventDefault();
            var $this           = $(this);
            var $product_id     = $this.parents(".product").find(".cd-vs-id").val();
            var $message_div    = $this.parents(".product").find(".cd-vs-message");
            if ( $product_id != 0 ) {
                $.ajax({
                    url: CODESIGNER.ajaxurl,
                    data: {
                        action: "cd-vs-add-to-cart",
                        _wpnonce: CODESIGNER._wpnonce,
                        product_id: $product_id,
                    },
                    type: "POST",
                    dataType: "JSON",
                    success: function (resp) {
                        $message_div.html( resp.html );
                        $message_div.show();
                    },
                    error: function (resp) {
                        console.log(resp);
                    },
                });
            }
            else{
                $message_div.html( 'Choose a Variation First' );
                $message_div.show();
                setTimeout(function() {
                    $message_div.hide();
                  }, 2000);
            }
        });
    });
});
