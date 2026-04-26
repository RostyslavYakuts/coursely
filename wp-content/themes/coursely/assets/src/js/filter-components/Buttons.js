import React from 'react';

const Buttons = ({handleReset, loading}) => (
	<div className="mt-4 flex flex-wrap items-center justify-between gap-2">
	<button
		disabled={loading}
		className=" mt-4 text-center inline-block p-2 w-[125px] uppercase font-semibold rounded-md bg-brand text-white hover:bg-brand-mid-light"
		type="submit">

		{loading? (
			<span className="spinner"></span>
			): (
				<><i className="pr-1 fa fa-filter" aria-hidden="true"></i>Вибрати</>
		)}

	</button>
	<button
			className="mt-4 text-center inline-block p-2 w-[125px] uppercase font-semibold rounded-md bg-brand text-white hover:bg-brand-mid-light"
		type="reset"
		onClick={handleReset}>
		<i className="fa pr-1 fa-refresh" aria-hidden="true"></i>Скинути
	</button>
	</div>
);


export default Buttons;
