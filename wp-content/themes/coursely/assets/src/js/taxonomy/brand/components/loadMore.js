export const loadMore = ()=>{
    const btn = document.querySelector('.load-more-products-js');

    if (btn) {
        btn.addEventListener('click', async function () {

            let page = parseInt(this.dataset.page);
            const maxPages = parseInt(this.dataset.maxNumPages);
            const termId = this.dataset.termId;

            if (page >= maxPages) {
                this.remove();
                return;
            }

            this.disabled = true;

            const response = await fetch(
                `/wp-json/custom/v1/products?page=${page + 1}&term_id=${termId}`
            );

            const data = await response.json();

            if (data.html) {
                document
                    .querySelector('.default-products-list')
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