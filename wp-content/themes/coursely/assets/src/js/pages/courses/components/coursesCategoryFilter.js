export const coursesCategoryFilter = () => {

    let page = 1;
    let hasMore = true;
    let loading = false;
    let currentTerm = 'all';

    const container = document.querySelector('.courses-js');

    if (!container) return;

    // ======================
    // LOAD MORE
    // ======================
    const loadMore = async () => {
        if (!hasMore || loading || currentTerm !== 'all') return;

        loading = true;
        page++;

        const res = await fetch(
            `/wp-json/courses/v1/filter?term_id=${currentTerm}&page=${page}&per_page=12`
        );

        const data = await res.json();

        hasMore = data.has_more;

        container.insertAdjacentHTML('beforeend', data.html);

        observeLast();

        loading = false;
    };

    // ======================
    // OBSERVER
    // ======================
    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            loadMore();
        }
    });

    const observeLast = () => {
        const items = container.querySelectorAll('.course-card');
        const last = items[items.length - 1];

        if (last) {
            observer.disconnect();
            observer.observe(last);
        }
    };

    // ======================
    // TAB CLICK
    // ======================
    document.addEventListener('click', async e => {

        const tab = e.target.closest('.course-tab-js');
        if (!tab) return;

        document
            .querySelectorAll('.course-tab-js')
            .forEach(el => el.classList.remove('active'));

        tab.classList.add('active');

        const termId = tab.dataset.id || 'all';

        currentTerm = termId;
        page = 1;
        hasMore = true;

        if (termId !== 'all') {
            hasMore = false; // turn off infinite scroll
        }

        container.classList.add('loading');

        const res = await fetch(
            `/wp-json/courses/v1/filter?term_id=${termId}&per_page=12`
        );

        const data = await res.json();

        container.innerHTML = data.html;

        container.classList.remove('loading');

        observeLast(); // only for all tab
    });

    // ======================
    // INIT
    // ======================
    observeLast();
};