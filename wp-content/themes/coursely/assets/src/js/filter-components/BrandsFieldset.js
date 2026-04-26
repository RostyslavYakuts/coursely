import React, {useEffect, useState} from "react";
import { BrandsModel } from './BrandsModel';


const BrandsFieldset = ({ formData, handleCheckboxChange, isLegendOpen, handleLegendToggle }) => {

	const [brands, setBrands] = useState([]);
	useEffect(() => {
		BrandsModel().then(setBrands);
	}, []);
	return (<fieldset className="filter-block mt-4">
		<legend
			className={`filter-legend text-xl font-bold legend-trigger-js ${isLegendOpen['brands'] ? '' : 'closed'}`}
			onClick={() => handleLegendToggle('brands')}
		>
			<i className="text-brand fa fa-flag" aria-hidden="true"></i> Бренд
		</legend>
		{isLegendOpen['brands'] && (
			<div className="items-group items-group-js checkbox-group">
				{brands.map((brand) => (
					<div className="flex items-center mt-2" key={brand.id}>
						<label htmlFor={`brand_${brand.slug}`}>
							<input
								type="checkbox"
								id={`brand_${brand.slug}`}
								name={`brand_${brand.slug}`}
								value={brand.term_id}
								checked={formData.brands.includes(brand.term_id.toString())}
								onChange={(e) => handleCheckboxChange(e, 'brands')}
							/>
							<span className="pseudo-checkbox"></span>
							{brand.name}
						</label>
					</div>
				))}
			</div>
		)}
	</fieldset>);
};

export default BrandsFieldset;
