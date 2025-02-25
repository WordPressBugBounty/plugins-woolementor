jQuery(function ($) {
	if (typeof CODESIGNER_NOTICE == "undefined") {
		return;
	}
});
document.addEventListener("DOMContentLoaded", function () {
	var countdownElements = document.querySelectorAll(".codesigner-countdown");

	countdownElements.forEach(function (element) {
		var endTime = new Date(
			element.getAttribute("data-countdown-end")
		).getTime();
		var timer = setInterval(function () {
			var now = new Date().getTime();
			var t = endTime - now;
			if (t >= 0) {
				element.querySelector("#days").innerText = Math.floor(
					t / (1000 * 60 * 60 * 24)
				);
				element.querySelector("#hours").innerText = Math.floor(
					(t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
				);
				element.querySelector("#minutes").innerText = Math.floor(
					(t % (1000 * 60 * 60)) / (1000 * 60)
				);
				element.querySelector("#seconds").innerText = Math.floor(
					(t % (1000 * 60)) / 1000
				);
			} else {
				clearInterval(timer);
				element.innerHTML = "EXPIRED";
			}
		}, 1000);
	});
});
