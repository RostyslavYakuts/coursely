import $ from 'jquery';
import 'select2';
import 'select2/dist/css/select2.css';

export const selectCountries = () => {
    const $country = $('#subscriber_country');

    if (!$country.length) return;

    $country.select2({
        placeholder: 'Select country',
        allowClear: true,
        width: '100%',
        minimumResultsForSearch: 0
    });
};