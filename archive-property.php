<?php
get_header();

if (function_exists('the_breadcrumbs')) {
    the_breadcrumbs();
}

// Include the filter logic.
require_once get_template_directory() . '/inc/property_filter/property-filter-logic.php';

// Retrieve filter data after ACF initialization.
$filter_data = allora_get_filter_data();
set_query_var('filter_data', $filter_data);

// Include the filter template.
get_template_part('template_parts/archive/filter', 'property');

get_footer();