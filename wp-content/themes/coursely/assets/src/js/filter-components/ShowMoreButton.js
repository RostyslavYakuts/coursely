import React from 'react';

const ShowMoreButton = ({handleShowMore, loadingForShowMore}) => (
	<div className="mt-6">
		<button
			disabled={loadingForShowMore}
			className="text-center inline-block p-4 rounded bg-brand text-white hover:bg-brand-hover"
			onClick={handleShowMore}>
			{loadingForShowMore ? (
				<span className="spinner"></span>
			) : (
				<>Показати більше</>
			)}
		</button>
	</div>
);


export default ShowMoreButton;
