export const loadMorePosts = ()=>{
    const btn = document.getElementById('load_more_posts');

    if (btn) {
        btn.addEventListener('click', async function () {

            let page = parseInt(this.dataset.page);
            const maxPages = parseInt(this.dataset.maxNumPages);
            if (page >= maxPages) {
                this.remove();
                return;
            }

            this.disabled = true;

            const response = await fetch(
                `/wp-json/blog/v1/posts?page=${page + 1}`
            );

            const data = await response.json();

            if (data.html) {
                document
                    .querySelector('.all-articles-js')
                    .insertAdjacentHTML('beforeend', data.html);

                this.dataset.page = page + 1;
                this.disabled = false;
            }

            if (page + 1 >= data.max_pages) {
                this.remove();
            }
        });
    }
}