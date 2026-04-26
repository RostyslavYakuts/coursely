export const scrollToTop = () => {
    const buttons = document.querySelectorAll('.scroll-to-top-js');

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
};