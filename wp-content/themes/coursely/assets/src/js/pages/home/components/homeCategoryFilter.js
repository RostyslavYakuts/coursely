export const homeCategoryFilter = ()=>{

    document.addEventListener('click', async e => {

        const tab = e.target.closest('.course-tab-js');

        if (!tab) return;


        document
            .querySelectorAll('.course-tab-js')
            .forEach(el => el.classList.remove('active'));

        tab.classList.add('active');


        const termId = tab.dataset.id || '';

        const wrap =
            document.querySelector('.courses-js');

        wrap.classList.add('loading');


        const res = await fetch(
            `/wp-json/courses/v1/filter?term_id=${termId}`
        );

        const data = await res.json();

        wrap.innerHTML = data.html;

        wrap.classList.remove('loading');

    });
}