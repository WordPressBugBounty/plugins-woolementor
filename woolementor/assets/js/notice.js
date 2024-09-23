jQuery(function ($) {
	if (typeof CODESIGNER_NOTICE == "undefined") {
		return;
	}

	// $(".cx-free-banner-close").on("click", function (e) {
	// 	e.preventDefault();
	// 	$(".cd-notice-content").hide();
	// 	$.ajax({
	// 		url: CODESIGNER_NOTICE.ajaxurl,
	// 		data: {
	// 			action: "hide-banner",
	// 			_wpnonce: CODESIGNER_NOTICE._wpnonce,
	// 		},
	// 		type: "POST",
	// 		dataType: "JSON",
	// 		success: function (resp) {
	// 			$(".cx-free-banner").hide();
	// 		},
	// 		error: function (resp) {},
	// 	});
	// });

	// $(".cd-notice").on("click", function (e) {
	// 	e.preventDefault();
	// 	$this = $(this);
	// 	$data_key = $this.closest(".cd-admin_notice").data("id");
	// 	$link = $(".cx-banner").attr("href");

	// 	if ($data_key == "") {
	// 		return;
	// 	}

	// 	$.ajax({
	// 		url: CODESIGNER_NOTICE.ajaxurl,
	// 		data: {
	// 			action: "complete-setting-close",
	// 			_wpnonce: CODESIGNER_NOTICE._wpnonce,
	// 			data_key: $data_key,
	// 		},
	// 		type: "POST",
	// 		dataType: "JSON",
	// 		success: function (resp) {
	// 			$this.closest(".cd-admin_notice").hide();
	// 		},
	// 	});
	// });

	// $(document).on("click", ".cx-dismiss-popup", function (e) {
	// 	e.preventDefault();
	// 	var nonce = $(".cx-nonce").val();
	// 	var href = $(".cd-notice_ahref").attr("href");

	// 	$.ajax({
	// 		url: CODESIGNER_NOTICE.ajaxurl,
	// 		data: {
	// 			action: "codesigner_admin_notice",
	// 			_wpnonce: nonce,
	// 		},
	// 		type: "POST",
	// 		dataType: "JSON",
	// 		success: function (resp) {
	// 			$(".cx-nonce").closest(".wp-pointer-content").hide();
	// 			window.open(href, "_blank");
	// 		},
	// 	});
	// });



	// Dismiss notice

	$(document).on('click', '.codesigner-dismissible-notice-button', function() {
		var noticeType = $('.codesigner-dismissible-notice-button').data('id');
	
		$.ajax({
			url: CODESIGNER_NOTICE.ajaxurl,
			type: 'post',
			data: {
				action: 'codesigner_dismiss_notice',
				notice_type: noticeType,
				_wpnonce: CODESIGNER_NOTICE._wpnonce
			},
			success: function(resp) {
				window.location.href = resp.url;
			}
		});
	});
	
});
