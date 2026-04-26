import React from "react";
import SortingFieldset from "./SortingFieldset";
import ProductCategoriesFieldset from "./ProductCategoriesFieldset";
import BrandsFieldset from "./BrandsFieldset";
import PriceFieldset from "./PriceFieldset";
import DiscountFieldset from "./DiscountFieldset";
import Buttons from "./Buttons";


const Filter = ({currentCategoryId, childCategoryId, formData, handleSubmit, handleChange, handleCheckboxChange, handleReset, loading, isLegendOpen, handleLegendToggle}) => (
<div className="products-filter">
	<form id="filter_form" className="filter-form" onSubmit={handleSubmit}>
		<SortingFieldset formData={formData} handleChange={handleChange} isLegendOpen={isLegendOpen}
						 handleLegendToggle={handleLegendToggle}/>
		<ProductCategoriesFieldset currentCategoryId={currentCategoryId} childCategoryId={childCategoryId} formData={formData} handleLegendToggle={handleLegendToggle} isLegendOpen={isLegendOpen}
						handleCheckboxChange={handleCheckboxChange}/>
		<BrandsFieldset formData={formData} handleLegendToggle={handleLegendToggle} isLegendOpen={isLegendOpen}
						handleCheckboxChange={handleCheckboxChange}/>
		<PriceFieldset formData={formData} handleLegendToggle={handleLegendToggle} isLegendOpen={isLegendOpen}
					   handleChange={handleChange}/>
		<DiscountFieldset formData={formData} handleLegendToggle={handleLegendToggle} isLegendOpen={isLegendOpen}
						  handleChange={handleChange}/>
		<Buttons handleReset={handleReset} loading={loading}/>
	</form>
</div>
);
export default Filter;
