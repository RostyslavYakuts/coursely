export const colorMenuOnScroll = () => {
    const header = document.querySelector('.total-header');

    const toggleHeader = () => {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    };

    toggleHeader();

    window.addEventListener('scroll', toggleHeader);
};