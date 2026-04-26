export const hamburger = () => {
	const hamburger = document.querySelector('.hamburger-js');
	const menu = document.querySelector('.main-menu-js');
	const body = document.body;

	if (!hamburger || !menu) return;

	hamburger.addEventListener('click', (e) => {
		e.stopPropagation();

		const isVisible = menu.style.display === 'block';

		hamburger.classList.toggle('opened');

		if (isVisible) {
			menu.style.display = 'none';
			body.classList.remove('shadow');
		} else {
			menu.style.display = 'block';
			body.classList.add('shadow');
		}
	});
};