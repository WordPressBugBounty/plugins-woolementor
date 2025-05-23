jQuery(function ($) {
	if (typeof CODESIGNER_NOTICE == "undefined") {
		return;
	}

	$(document).ready(function () {
		// Change background color of codesigner menu last item
		$("#adminmenu .toplevel_page_codesigner .wp-submenu-wrap li a[href$='admin.php?page=codesigner-get-pro']").css({"background-color":"#ff6640","font-size":"12px"});

		// Set the date we're counting down to
		var countDownDate = new Date("May 30, 2025 23:59:59").getTime();

		// Update the countdown every 1 second
		var x = setInterval(function () {
			// Get today's date and time
			var now = new Date().getTime();

			// Find the distance between now and the countdown date
			var distance = countDownDate - now;

			// Time calculations for days, hours, minutes, and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor(
				(distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
			);
			var minutes = Math.floor(
				(distance % (1000 * 60 * 60)) / (1000 * 60)
			);
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Output the result in the respective elements
			$("#days").text(days);
			$("#hours").text(hours);
			$("#minutes").text(minutes);
			$("#seconds").text(seconds);

			// If the countdown is over, write some text
			if (distance < 0) {
				clearInterval(x);
				$("#countdown").html("EXPIRED");
			}
		}, 1);
	});
});
