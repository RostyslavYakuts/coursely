import { useState } from 'react';
import { useRef } from 'react';
const FilterController = () => {
	const [formData, setFormData] = useState({
		sorting: '',
		price_from: 100,
		price_to: 5000,
		discount: false,
		product_categories: [],
		brands: []
	});
	const [scrollMode, setScrollMode] = useState(null);
	const productListRef = useRef(null);
	const legendIds = ['sorting', 'product_categories', 'brands', 'price', 'discount'];
	const [isLegendOpen, setIsLegendOpen] = useState(
		legendIds.reduce((acc, id) => {
			acc[id] = true;
			return acc;
		}, {})
	);

	const handleLegendToggle = (id) => {
		setIsLegendOpen((prev) => ({
			...prev,
			[id]: !prev[id]
		}));
	};

	const handleChange = (e) => {
		const { name, value, type, checked } = e.target;
		setFormData((prevData) => ({
			...prevData,
			[name]: type === 'checkbox' ? checked : value
		}));
	};

	const handleCheckboxChange = (e, category) => {
		const { value, checked } = e.target;
		setFormData((prevData) => ({
			...prevData,
			[category]: checked
				? [...new Set([...prevData[category], value])]
				: prevData[category].filter((item) => item !== value),
		}));
	};

	const [phpProductsRemoved, setPhpProductsRemoved] = useState(false);

	const removePhpProducts = () => {
		if (!phpProductsRemoved) {
			const phpProductsContainer = document.getElementById('default_products');
			if (phpProductsContainer) {
				phpProductsContainer.innerHTML = '';
				setPhpProductsRemoved(true);
			}
		}
	};

	const fetchProducts = async (formData, paged) => {
		const response = await fetch('/wp-json/custom/v1/filter', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ ...formData, paged }),
		});
		return await response.json();
	};

	const [loading, setLoading] = useState(false);
	const [loadingForShowMore, setLoadingForShowMore] = useState(false);
	const [filteredProducts, setFilteredProducts] = useState([]);
	const [page, setPage] = useState(1); // Track the current page
	const [hasMore, setHasMore] = useState(true); // Track if more products exist
	const [hasFiltered, setHasFiltered] = useState(false);
	const handleSubmit = async (e) => {
		e.preventDefault();
		setPage(1); // Reset to the first page when the filter is applied
		setLoading(true);
		try {
			const result = await fetchProducts(formData, 1);
			// Remove PHP-rendered products only once
			removePhpProducts();
			setScrollMode('top');
			setFilteredProducts(result.products || []);
			setHasMore(result.has_more || false); // Update hasMore based on the response
			setHasFiltered(true);

		} catch (error) {
			console.error('Error fetching filtered products:', error);
		} finally{
			setLoading(false)
		}
	};

	// Handle "Show More" button click
	const handleShowMore = async () => {
		const nextPage = page + 1;
		setLoadingForShowMore(true);
		try {
			setScrollMode('bottom');
			const result = await fetchProducts(formData, nextPage);
			setFilteredProducts((prevProducts) => [...prevProducts, ...result.products]);
			setPage(nextPage);
			setHasMore(result.has_more || false); // Check if more products exist
		} catch (error) {
			console.error('Error fetching more products:', error);
		} finally{
			setLoadingForShowMore(false);
		}
	};



	const handleReset = () => {
		setFormData({
			sorting: '',
			price_from: 100,
			price_to: 5000,
			discount: false,
			product_categories: [],
			brands: []
		});
	};

	return {
		formData,
		handleChange,
		handleCheckboxChange,
		handleSubmit,
		handleReset,
		isLegendOpen,
		handleLegendToggle,
		filteredProducts,
		handleShowMore,
		hasMore,
		hasFiltered,
		loading,
		loadingForShowMore,
		productListRef,
		scrollMode,
		setScrollMode
	};
};

export default FilterController;

