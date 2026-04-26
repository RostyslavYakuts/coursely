import React, { useEffect } from "react";
import ReactDOM from 'react-dom';
import Filter from "./filter-components/Filter"
import FilterController from "./filter-components/FilterController";
import FilteredItems from "./filter-components/FilteredItems"
import ShowMoreButton	 from "./filter-components/ShowMoreButton";
import { createRoot } from 'react-dom/client';
import FilteredProductsList from "./filter-components/FilteredProductsList";
const ProductFilter = ({childCategoryId, currentCategoryId}) => {
	const {
		formData,
		handleChange,
		handleCheckboxChange,
		handleSubmit,
		handleReset,
		isLegendOpen,
		handleLegendToggle,
		filteredProducts,
		handleShowMore,
		hasMore,
		hasFiltered,
		loading,
		loadingForShowMore,
		productListRef,
		scrollMode,
		setScrollMode
	} = FilterController();

	useEffect(() => {
		if (!hasFiltered) return;
		const container = document.getElementById("default_products");
		if (container) {
			const root = createRoot(container);
			root.render(
				<FilteredProductsList
					products={filteredProducts}
					hasMore={hasMore}
					handleShowMore={handleShowMore}
					loadingForShowMore={loadingForShowMore}
					productListRef={productListRef}
				/>
			);
		}
	}, [hasFiltered,filteredProducts, hasMore, loadingForShowMore]);

	useEffect(() => {
		if (!productListRef.current) return;
		if (!scrollMode) return;

		if (scrollMode === 'top') {
			productListRef.current.scrollIntoView({
				behavior: 'smooth',
				block: 'start'
			});
		}

		if (scrollMode === 'bottom') {
			productListRef.current.lastElementChild?.scrollIntoView({
				behavior: 'smooth',
				block: 'end'
			});
		}

		setScrollMode(null);

	}, [filteredProducts]);
	return (

		<Filter currentCategoryId={currentCategoryId} childCategoryId={childCategoryId} formData={formData} loading={loading} handleReset={handleReset}
				handleChange={handleChange} handleCheckboxChange={handleCheckboxChange}
				handleSubmit={handleSubmit} handleLegendToggle={handleLegendToggle}
				isLegendOpen={isLegendOpen} />

	);
};

// Deprecated! ReactDOM.render(<ProductFilter/>, document.getElementById('product_filter'));
const container = document.getElementById('product_filter');
const currentCategoryId = container.dataset.currentId;
const parentId = container.dataset.parentId;
let childCategoryId = '';
if(parentId){
	childCategoryId = currentCategoryId;
}
if (container) {
	const root = createRoot(container);
	root.render(<ProductFilter currentCategoryId={currentCategoryId} childCategoryId={childCategoryId}/>);
}