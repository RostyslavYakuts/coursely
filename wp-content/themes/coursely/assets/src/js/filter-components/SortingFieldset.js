import React from 'react';
import { useSpring, animated } from 'react-spring';

const SortingFieldset = ({ formData, handleChange, isLegendOpen, handleLegendToggle }) => (
	<fieldset className="filter-block mt-4">
		<legend
			className={`filter-legend text-xl font-bold legend-trigger-js ${isLegendOpen['sorting'] ? '' : 'closed'}`}
			onClick={() => handleLegendToggle('sorting')}
		>
			<i className="text-brand fa fa-sort-amount-asc" aria-hidden="true"></i> Сортування
		</legend>
		<animated.div
			style={useSpring({
				maxHeight: isLegendOpen['sorting'] ? '200px' : '0px',
				opacity: isLegendOpen['sorting'] ? 1 : 0,
				overflow: 'hidden',
				config: { tension: 300, friction: 30 },
			})}
		>
				<div className="flex justify-between items-center">
					<select
						className="border border-black p-2 mt-2 bg-white"
						id="sorting"
						name="sorting"
						value={formData.sorting}
						onChange={handleChange}
					>
						<optgroup label="Параметри">
							<option value="date_from_last">Новинки</option>
							<option value="price_asc">Від меншої ціни</option>
							<option value="price_desc">Від більшої ціни</option>
						</optgroup>
					</select>
				</div>
		</animated.div>
	</fieldset>
);

export default SortingFieldset;
