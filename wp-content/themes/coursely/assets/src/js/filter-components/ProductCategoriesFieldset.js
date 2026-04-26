import React, {useEffect, useState} from "react";
import {ProductCategoriesModel} from "./ProductCategoriesModel";



const ProductCategoriesFieldset = ({ currentCategoryId, childCategoryId, formData, handleCheckboxChange, isLegendOpen, handleLegendToggle }) => {
	const [productCategories, setProductCategories] = useState([]);
	useEffect(() => {
		ProductCategoriesModel(currentCategoryId).then(setProductCategories);
	}, [currentCategoryId]);
	useEffect(() => {
		const selected = formData.product_categories || [];

		// CASE 1: Is child category
		// Add child cat in formData - in case child on category page the child must be in form data
		if (childCategoryId === currentCategoryId) {
			if (!selected.includes(childCategoryId.toString())) {
				handleCheckboxChange(
					{ target: { value: childCategoryId, checked: true } },
					'product_categories',
					true
				);
			}
			return;
		}
		// CASE 2: Parent category and child checkbox are not checked
		if (!childCategoryId && currentCategoryId) {
			const parentStr = currentCategoryId.toString();
			if (selected.length === 0) {
				handleCheckboxChange(
					{ target: { value: parentStr, checked: true } },
					'product_categories',
					true
				);
			}
			if (selected.length > 1 && selected.includes(parentStr)) {
				handleCheckboxChange(
					{ target: { value: parentStr, checked:false } },
					'product_categories',
					true
				);
			}
		}

	}, [formData.product_categories,currentCategoryId,childCategoryId]);

	return (<fieldset className="filter-block mt-4">
			<legend
				className={`filter-legend text-xl font-bold legend-trigger-js ${isLegendOpen['product_categories'] ? '' : 'closed'}`}
				onClick={() => handleLegendToggle('product_categories')}
			>
				<i className="text-brand fa fa-bookmark" aria-hidden="true"></i> Категорії товарів
			</legend>

			{isLegendOpen['product_categories'] && (
				<div className="items-group items-group-js checkbox-group">
				{productCategories.map((productCategory) => {
					const isCurrent = productCategory.term_id === Number(childCategoryId);
					return (<div className="flex items-center mt-2" key={productCategory.term_id}>
						<label htmlFor={`product_category_${productCategory.slug}`}>
							<input
								type="checkbox"
								id={`product_category_${productCategory.slug}`}
								name={`product_category_${productCategory.slug}`}
								value={productCategory.term_id}
								checked={
									formData.product_categories.includes(productCategory.term_id.toString())
								}
								disabled={isCurrent}
								onChange={(e) => handleCheckboxChange(e, 'product_categories')}
							/>
							<span className="pseudo-checkbox"></span>
							{productCategory.name}
						</label>
					</div>
					)
				})}
			</div>
		)}
	</fieldset>
	);
};

export default ProductCategoriesFieldset;
