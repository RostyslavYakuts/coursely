
export const marqueeSlider = () => {
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.querySelector('#marquee_slider');
        const list = document.querySelector('#list');
        if (!list || !container) return;

        const items = [...list.children];

        items.forEach(item => {
            const clone = item.cloneNode(true);
            list.appendChild(clone);
        });

        let pos = 0;
        const speed = 0.5;

        function animate() {
            pos -= speed;
            if (Math.abs(pos) >= items[0].offsetWidth * items.length) {
                pos = 0;
            }
            list.style.transform = `translateX(${pos}px)`;
            requestAnimationFrame(animate);
        }

        animate();
    });
};