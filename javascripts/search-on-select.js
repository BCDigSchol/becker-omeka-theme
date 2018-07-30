(function ($) {
    function search_on_select(search_field_id, search_term) {
        var search_base = 'http://beckercollection.bc.edu/items/browse',
            search_scope = 'advanced[0][type]=is exactly',
            search_type = 'advanced[0][element_id]=' + encodeURIComponent(search_field_id),
            search_value = 'advanced[0][terms]=' + encodeURIComponent(search_term),
            params = [search_type, search_scope, search_value];

        if (search_term.indexOf('http') !== -1) {
            // If the value is a URL, redirect.
            window.location = search_term;
        } else if (search_term) {
            window.location = search_base + '?' + params.join('&');
        }
    };

    $('#battle-search').change(function () {
        search_on_select('49', $(this).val());
    });
}(jQuery));
