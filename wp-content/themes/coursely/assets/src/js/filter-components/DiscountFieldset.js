import React from 'react';
import { useSpring, animated } from 'react-spring';
const DiscountFieldset = ({formData,handleChange,isLegendOpen,handleLegendToggle}) => (
    <fieldset className="filter-block mt-4">
        <legend
            className={`filter-legend text-xl font-bold legend-trigger-js ${isLegendOpen['discount'] ? '' : 'closed'}`}
            onClick={() => handleLegendToggle('discount')}
        >
            <i className="text-brand fa fa-percent" aria-hidden="true"></i> Дисконт
        </legend>
        <animated.div
            style={useSpring({
                maxHeight: isLegendOpen['discount'] ? '200px' : '0px',
                opacity: isLegendOpen['discount'] ? 1 : 0,
                overflow: 'hidden',
                config: {tension: 300, friction: 30},
            })}
        >
            <div className="items-group items-group-js">
                <div className="flex items-center mt-2">
                    <label htmlFor="discount">
                        <input
                            type="checkbox"
                            id="discount"
                            name="discount"
                            value="yes"
                            checked={formData.discount}
                            onChange={handleChange}
                        />
                        <span className="pseudo-checkbox"></span>
                        Тільки зі знижкою
                    </label>
                </div>
            </div>
        </animated.div>
    </fieldset>
);

export default DiscountFieldset;
