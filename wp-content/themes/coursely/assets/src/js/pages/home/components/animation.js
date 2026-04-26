export const animation = () => {

    const hero = document.querySelector('.hero-section');

    if (hero) {
        const activateHeroAnimation = () => {
            hero.classList.remove('default');
            hero.classList.add('animations-ready');
        };

        ['mousemove', 'touchstart', 'click'].forEach(evt =>
            hero.addEventListener(evt, activateHeroAnimation, { once: true })
        );
    }


    const animatedElements = document.querySelectorAll('[data-animate]');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    animatedElements.forEach(el => observer.observe(el));
};