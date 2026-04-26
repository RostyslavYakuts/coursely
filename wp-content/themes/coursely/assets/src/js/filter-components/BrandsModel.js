export const BrandsModel = async (brandId = null) => {
	try {
		let url = '/wp-json/custom/v1/brands';
		if (brandId) {
			url += `?term_id=${brandId}`;
		}
		const response = await fetch(url);
		const data = await response.json();
		console.log(data);
		return data;
	} catch (error) {
		console.error('Error fetching brands:', error);
		return [];
	}
};
