import React from "react";
import FilteredItems from "./FilteredItems";
import ShowMoreButton from "./ShowMoreButton";

const FilteredProductsList = ({ products, hasMore, handleShowMore, loadingForShowMore, productListRef }) => {
    if (products.length === 0) return <p className="text-center py-10">Нічого не знайдено</p>;

    return (
        <div  ref={productListRef} className="default-products-list grid grid-cols-2 lgx:grid-cols-3 gap-2 mdx:gap-6">
            {products.map(product => (
                <FilteredItems key={product.id} product={product} />
            ))}
            {hasMore && (
                <ShowMoreButton handleShowMore={handleShowMore} loadingForShowMore={loadingForShowMore} />
            )}
        </div>
    );
};

export default FilteredProductsList;