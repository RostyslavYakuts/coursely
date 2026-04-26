import React from "react";
import decodeHtmlEntities from "./decodeHtml";

const FilteredItems = ({product}) => (
		<a className="border border-brand rounded w-full mdx:w-[270px] h-[450px] xs:h-[520px] p-2 xs:p-4 flex flex-col gap-3 justify-between items-center" href={product.link}>
			<img width="300" height="300" className="w-[200px] max-w-[200px] h-[200px] max-h-[200px] object-contain mdx:object-cover mb-4" loading="lazy"
				 decoding="async" src={product.thumbnail}
				 alt={decodeHtmlEntities(product.title)}/>
			<h3
			   className="text-light-black hover:text-brand text-center text-lg font-semibold line-clamp-4 min-h-[86px]">
				{decodeHtmlEntities(product.title)}
			</h3>
			<span className="custom-star-rating block mx-auto relative w-[100px] h-[30px] ">
				<span style={{ width: `${product.rating || 0}%` }} className="rating-mark"></span>
			</span>
			<span className="text-sm text-light-black" dangerouslySetInnerHTML={{ __html: product.price }}>

			</span>
			<button aria-label="Visit" className="uppercase bg-brand hover:bg-brand-hover text-white p-3 rounded ">
				Переглянути
			</button>
	</a>
)

export default FilteredItems;
