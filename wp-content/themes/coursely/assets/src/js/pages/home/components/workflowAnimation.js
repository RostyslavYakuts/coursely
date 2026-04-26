export const workflowAnimation = () => {

    const container = document.querySelector('[data-workflow]');
    if(!container) return;

    const items = container.querySelectorAll('[data-step]');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {

            if(entry.isIntersecting){

                items.forEach((item,i)=>{
                    setTimeout(()=>{
                        item.classList.remove('opacity-0','scale-75','translate-y-10');
                    }, i * 120);
                });

                observer.unobserve(container);
            }

        });

    },{threshold:0.25});

    observer.observe(container);
}