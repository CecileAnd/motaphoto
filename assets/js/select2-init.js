jQuery(document).ready(function($) {
    $('select').select2();
});

jQuery(document).ready(function($) {
    $('.select2-no-search').select2({
        minimumResultsForSearch: Infinity,
        placeholder: function() {
            return $(this).find('option:first').text();
        },
        allowClear: false,
        dropdownCssClass: 'select2-custom-dropdown'
    });
});

