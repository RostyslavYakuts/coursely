export const AnimateNumbers = () => {
	const elements = document.querySelectorAll('.animate-number-js');
	let animationTriggered = false;

	const animate = (el, target) => {
		let current = 0;
		const step = () => {
			current++;
			el.textContent = current;
			if (current < target) {
				requestAnimationFrame(step);
			}
		};
		requestAnimationFrame(step);
	};

	const onScroll = () => {
		if (animationTriggered) return;

		const sectionOffset = elements[0].getBoundingClientRect().top + window.scrollY;

		if (window.scrollY + window.innerHeight > sectionOffset + 100) {
			elements.forEach((el) => {
				const target = parseInt(el.dataset.statistic, 10);
				animate(el, target);
				el.classList.remove('animate-number-js');
			});

			animationTriggered = true;
			window.removeEventListener('scroll', onScroll);
		}
	};

	if (elements.length) {
		window.addEventListener('scroll', onScroll);
		onScroll();
	}
};