import React from 'react';
import { useSpring, animated } from 'react-spring';
const PriceFieldset = ({formData, handleChange, isLegendOpen, handleLegendToggle}) => (
    <fieldset className="filter-block mt-4">
        <legend
            className={`filter-legend text-xl font-bold legend-trigger-js ${isLegendOpen['price'] ? '' : 'closed'}`}
            onClick={() => handleLegendToggle('price')}
        >
            <i className="text-brand fa fa-money" aria-hidden="true"></i> Ціна
        </legend>
        <animated.div
            style={useSpring({
                maxHeight: isLegendOpen['price'] ? '200px' : '0px',
                opacity: isLegendOpen['price'] ? 1 : 0,
                overflow: 'hidden',
                config: {tension: 300, friction: 30},
            })}
        >
                <div className="mt-4 items-group items-group-js">
                    <div className="flex justify-between items-center">
                        <div className="flex justify-between items-center">
                            <label className="pr-1" htmlFor="price_from">від</label>
                            <input className="border border-black pl-1 w-[80px]"
                                   id="price_from"
                                   name="price_from"
                                   type="number"
                                   step="10"
                                   value={formData.price_from}
                                   onChange={handleChange}
                                   min="100"
                                   max="150000"
                            />
                        </div>
                        <div className="flex justify-between items-center">
                            <label className="pr-1" htmlFor="price_to">до</label>
                            <input
                                className="border border-black pl-1 w-[80px]"
                                id="price_to"
                                name="price_to"
                                type="number"
                                step="10"
                                value={formData.price_to}
                                onChange={handleChange}
                                min="100"
                                max="150000"
                            />
                        </div>
                    </div>
                </div>
        </animated.div>
    </fieldset>
);

export default PriceFieldset;
