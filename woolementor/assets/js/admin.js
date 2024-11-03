jQuery(function ($) {
	$(".wcd_template_tabs .wcd_template_tab").on("click", function (e) {
		e.preventDefault();
		var tab_id = $(this).attr("id");
		$(".wcd_template_tab").removeClass("active");
		$(this).addClass("active");

		$(".wcd_template_content").hide();
		$("#" + tab_id + "_content").show();

		// template
		$(".tmpl-wl-templates-modal-preview-iframe").hide();
		$(".wcd-tmpl-wrapper").show();
		$(".tmpl-wl-templates-modal-preview-iframe iframe").attr("src", "");
	});

	$("#wl_faq").click(function (e) {
		$("#wl_vidtt, #wl_support").removeClass("active");
		$(this).addClass("active");

		$("#wl_vidtt_content, #wl_support_content").removeClass("active");
		$("#wl_faq_content").addClass("active");
	});
	$("#wl_vidtt").click(function (e) {
		$("#wl_faq, #wl_support").removeClass("active");
		$(this).addClass("active");

		$("#wl_faq_content, #wl_support_content").removeClass("active");
		$("#wl_vidtt_content").addClass("active");
	});
	$("#wl_support").click(function (e) {
		$("#wl_faq, #wl_vidtt").removeClass("active");
		$(this).addClass("active");

		$("#wl_faq_content, #wl_vidtt_content").removeClass("active");
		$("#wl_support_content").addClass("active");
	});

	$(".codesigner-help-heading").click(function (e) {
		var $this = $(this);
		var target = $this.data("target");
		$(".codesigner-help-text:not(" + target + ")").slideUp();
		if ($(target).is(":hidden")) {
			$(target).slideDown();
		} else {
			$(target).slideUp();
		}
	});

	$("#wl-report-copy").click(function (e) {
		e.preventDefault();
		$("#codesigner_tools-report").select();

		try {
			var successful = document.execCommand("copy");
			if (successful) {
				$(this).html('<span class="dashicons dashicons-saved"></span>');
			}
		} catch (err) {
			console.log("Oops, unable to copy!");
		}
	});

	$(".wcd-tmpl-wrapper").on(
		"click",
		".elementor-template-library-template-preview",
		function (e) {
			$(".tmpl-admin-template-loader").show();
			var url = $(this).data("url");

			$(this).parents(".wcd-tmpl-wrapper").hide();
			$(".tmpl-wl-templates-modal-preview-iframe iframe").attr(
				"src",
				url
			);
			$(".tmpl-wl-templates-modal-preview-iframe").show();

			$(".wcd_tab_btns.wcd-tmpl-btns").hide();
			$(".tmpl-admin-template-header").show();

			setTimeout(function () {
				$(".tmpl-admin-template-loader").hide();
			}, 1000);
		}
	);

	$(document).on(
		"click",
		".tmpl-wl-template-library-header-preview-back",
		function (e) {
			$(".tmpl-admin-template-header").hide();
			$(".wcd_tab_btns.wcd-tmpl-btns").show();

			$(".tmpl-wl-templates-modal-preview-iframe").hide();
			$(".wcd-tmpl-wrapper").show();
			$(".tmpl-wl-templates-modal-preview-iframe iframe").attr("src", "");
			$(".tmpl-wl-templates-modal-preview-iframe").css("width", "100%");

			$('.wl__responsive-menu-item[data-tab="desktop"]').click();
		}
	);

	$(document).on("click", ".wl__responsive-menu-item", function (e) {
		var tab_view = $(this).data("tab");

		$(".wl__responsive-menu-item").removeClass("elementor-active");

		switch (tab_view) {
			case "desktop":
				$(this).addClass("elementor-active");
				$(".tmpl-wl-templates-modal-preview-iframe").css(
					"width",
					"100%"
				);
				break;
			case "tab":
				$(this).addClass("elementor-active");
				$(".tmpl-wl-templates-modal-preview-iframe").css(
					"width",
					"768px"
				);
				break;
			case "mobile":
				$(this).addClass("elementor-active");
				$(".tmpl-wl-templates-modal-preview-iframe").css(
					"width",
					"360px"
				);
				break;
			default:
				$(this).css("width", "100%");
				break;
		}
	});

	/**
	 * Template Libray synce
	 *
	 * @author Jakaria Istauk <jakariamd35@gmail.com>
	 */
	$(document).on("click", "#wcd-template-sync.clickable", function (e) {
		e.preventDefault();
		var sync_btn = $(this);
		sync_btn.addClass("spin").removeClass("clickable");
		$.ajax({
			url: CODESIGNER.ajaxurl,
			data: {
				action: "wcd-template-sync",
				_wpnonce: CODESIGNER._wpnonce,
			},
			type: "POST",
			dataType: "JSON",
			success: function (resp) {
				console.log(resp.message);
				sync_btn.removeClass("spin").addClass("clickable");
				if (resp.status == 1) {
					window.location.href = "";
				}
			},
			error: function (resp) {
				console.log(resp);
				sync_btn.removeClass("spin").addClass("clickable");
			},
		});
	});

	$(document).ready(function () {
		$("#wl-template-categories").on("change", function () {
			$("#wl-template-search").val("");
			var value = $(this).val().toLowerCase();
			$(
				".wcd-tmpl-wrapper .elementor-template-library-template-remote"
			).filter(function () {
				$(this).toggle(
					$(this).text().toLowerCase().indexOf(value) > -1
				);
			});
		});

		$("#wl-template-search").on("keyup", function () {
			$("#wl-template-categories").val("");
			var value = $(this).val().toLowerCase();
			$(
				".wcd-tmpl-wrapper .elementor-template-library-template-remote"
			).filter(function () {
				$(this).toggle(
					$(this).text().toLowerCase().indexOf(value) > -1
				);
			});
		});
	});

	$(document).on("click", ".wl-widget-type-title", function (e) {
		var par = $(this).parent();
		$(".wl-pro-widget-list-wrapper").slideUp();
		$(".wl-pro-widget-list-wrapper", par).slideToggle();
	});

	$(document).on("click", ".wl-services-video button", function (e) {
		$(".wl-modal-panel").show();
	});

	$("html, body").click(function (e) {
		if ($(e.target).hasClass("wl-modal-content")) {
			return false;
		}
		$(".wl-modal-panel").hide();
	});

	$(".wl-widget.pro .wl-pro-popup-show").click(function (e) {
		$("#wl-pro-popup").slideDown("fast");
	});

	$("#wl-pro-popup-hide").click(function (e) {
		$("#wl-pro-popup").slideUp("fast");
	});

	// modules pro popup show
	$(".cd-settings-module-block .cx-toggle-switch.pro").click(function (e) {
		$("#wl-pro-popup").slideDown("fast");
	});

	// activate or deactivate all modules
	$(".cd-module-all-active").click(function (e) {
		if (!$(".wl-toggle-all-wrap input").is(":checked")) {
			$('.cd-settings-modules-container input[type="checkbox"]').each(
				function () {
					if (!$(this).prop("disabled")) {
						$(this).prop("checked", true);
					}
				}
			);
		} else {
			$('.cd-settings-modules-container input[type="checkbox"]').each(
				function () {
					if (!$(this).prop("disabled")) {
						$(this).prop("checked", false);
					}
				}
			);
		}
	});

	$(document).on("click", ".cd-pro-table-control button", function (e) {
		$(".cd-pro-table-control button").removeClass("cd-active");

		$(this).addClass("cd-active");

		if ($(this).data("id") === "widget") {
			$("#cd-pro-table-module").hide();
			$("#cd-pro-table-widget").show();
		} else {
			$("#cd-pro-table-module").show();
			$("#cd-pro-table-widget").hide();
		}
	});

	/**
	 * Pointer Start
	 */

	$.each(CODESIGNER, function (index, pointer) {
		$(pointer.target)
			.pointer({
				content: pointer.content,
				pointerWidth: 380,
				position: {
					edge: pointer.edge,
					align: pointer.align,
				},
				close: function () {
					$.post(ajaxurl, {
						notice_name: index,
						_wpnonce: CODESIGNER._wpnonce,
						action: pointer.action,
					});
				},
			})
			.pointer("open");
	});

	/**
	 * Pointer End
	 *
	 */

	//pricing accordion in general
	$(".wl-accordion-header").click(function () {
		$(this).next(".wl-accordion-content").slideToggle(300);
		$(this).parent().toggleClass("active");

		// Close other accordion items
		$(".wl-accordion-item").not($(this).parent()).removeClass("active");
		$(".wl-accordion-content").not($(this).next()).slideUp(300);
	});
});
