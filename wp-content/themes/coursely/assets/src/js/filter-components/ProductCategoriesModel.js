export const ProductCategoriesModel = async (currentCategoryId = null) => {
    try {

        let url = '/wp-json/custom/v1/product_categories';
        if (currentCategoryId) {
            url += `?term_id=${currentCategoryId}`;
        }
        const response = await fetch(url);
        const data = await response.json();
        console.log(data);
        return data;

    } catch (error) {
        console.error('Error fetching product-categories:', error);
        return [];
    }
};
