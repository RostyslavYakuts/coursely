<script>
	let userInteractedAn = false;
	let timeoutPassedAn = false;

	window.addEventListener('mousemove', userInteractionAn);
	window.addEventListener('keydown', userInteractionAn);
	window.addEventListener('click', userInteractionAn);
	window.addEventListener('scroll', userInteractionAn);

	function userInteractionAn() {
		userInteractedAn = true;

		if (!timeoutPassedAn) {
			loadGtagScript();
		}

		window.removeEventListener('mousemove', userInteractionAn);
		window.removeEventListener('keydown', userInteractionAn);
		window.removeEventListener('click', userInteractionAn);
		window.removeEventListener('scroll', userInteractionAn);
	}

	window.addEventListener('DOMContentLoaded', () => {
		timeoutPassedAn = true;
		setTimeout(() => {
			if (!userInteractedAn) {
				loadGtagScript();
			}
		}, 5000);
	});

	function loadGtagScript() {
		let script = document.createElement('script');
		script.src = 'https://www.googletagmanager.com/gtag/js?id=G-M08XPK0K0M';
		script.async = true;
		script.onload = function () {
			window.dataLayer = window.dataLayer || [];
			function gtag() {
				window.dataLayer.push(arguments);
			}
			gtag('js', new Date());
			gtag('config', 'G-M08XPK0K0M');
		};
		document.head.appendChild(script);
	}
</script>