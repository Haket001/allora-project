<?php
/**
 * Property Filter Logic
 * Contains helper functions for populating the property filter form.
 */

/**
 * Returns current WPML language code.
 */
function allora_get_current_lang_code() {
    if (function_exists('apply_filters')) {
        $lang = apply_filters('wpml_current_language', null);
        if ($lang) {
            return $lang;
        }
    }
    return '';
}

/**
 * Returns a sanitized array from a GET parameter.
 */
function get_sanitized_array($key) {
    if (isset($_GET[$key])) {
        if (is_array($_GET[$key])) {
            return array_map('sanitize_text_field', $_GET[$key]);
        } else {
            return array_map('trim', explode(',', sanitize_text_field($_GET[$key])));
        }
    }
    return array();
}

/**
 * Helper function to retrieve filter parameter from GET or query var.
 * Optionally applies a transformation callback to each value.
 */
function get_filter_param($key, $transform = null) {
    $value = get_sanitized_array($key);
    if (empty($value)) {
        $q = get_query_var($key);
        if ($q) {
            $value = array_map('sanitize_text_field', array_map('trim', explode(',', $q)));
        }
    }
    if ($transform && is_callable($transform)) {
        $value = array_map($transform, $value);
    }
    return $value;
}

/**
 * Returns unique meta values for a given meta key.
 * Now uses transient caching for one week.
 */
function get_unique_meta_values($meta_key) {
    global $wpdb;
    $current_lang = allora_get_current_lang_code();
    
    // Build a cache key based on meta key and language
    $cache_key = 'allora_unique_meta_' . md5($meta_key . '_' . $current_lang);
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    if ($current_lang !== '') {
        $sql = $wpdb->prepare(
            "SELECT pm.meta_value
             FROM {$wpdb->postmeta} pm
             INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
             INNER JOIN {$wpdb->prefix}icl_translations t ON t.element_id = p.ID
             WHERE pm.meta_key = %s
               AND pm.meta_value != ''
               AND p.post_type = 'property'
               AND p.post_status = 'publish'
               AND t.language_code = %s
               AND t.element_type = 'post_property'",
            $meta_key,
            $current_lang
        );
    } else {
        $sql = $wpdb->prepare(
            "SELECT pm.meta_value
             FROM {$wpdb->postmeta} pm
             INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
             WHERE pm.meta_key = %s
               AND pm.meta_value != ''
               AND p.post_type = 'property'
               AND p.post_status = 'publish'",
            $meta_key
        );
    }

    $results = $wpdb->get_col($sql);
    if (empty($results)) {
        return [];
    }

    $arrays = array_map(function ($value) {
        $maybe_array = maybe_unserialize($value);
        return is_array($maybe_array) ? $maybe_array : [$value];
    }, $results);

    // Merge arrays safely.
    $flattened = [];
    foreach ($arrays as $arr) {
        $flattened = array_merge($flattened, $arr);
    }
    $flattened = array_unique($flattened);
    sort($flattened);
    
    // Cache result for one week (604800 seconds)
    set_transient($cache_key, $flattened, 604800);
    
    return $flattened;
}

/**
 * Retrieves and assembles filter data.
 * Should be called after ACF is initialized.
 */
function allora_get_filter_data() {
    // Define a transformation callback to convert underscores to spaces.
    $transform_callback = function($val) {
        return str_replace('_', ' ', $val);
    };

    // Retrieve filter parameters using the helper.
    $filter_condition     = get_filter_param('condition', $transform_callback);
    $filter_property_type = get_filter_param('property_type', $transform_callback);
    $filter_location      = get_filter_param('location', $transform_callback);
    $filter_features      = get_filter_param('features', $transform_callback);

    // Retrieve cost values from GET or query vars.
    $filter_cost_min = isset($_GET['cost_min']) ? floatval($_GET['cost_min']) : '';
    if ($filter_cost_min === '' && ($q = get_query_var('cost_min'))) {
        $filter_cost_min = floatval($q);
    }
    $filter_cost_max = isset($_GET['cost_max']) ? floatval($_GET['cost_max']) : '';
    if ($filter_cost_max === '' && ($q = get_query_var('cost_max'))) {
        $filter_cost_max = floatval($q);
    }

    // Retrieve texts from ACF fields (using fallback values).w
    $filter_all_conditions = esc_html__('Condition', 'allora');
    $filter_all_types      = esc_html__('Property Type', 'allora');
    $filter_all_locations  = esc_html__('Location', 'allora');
    $filter_all_features   = esc_html__('Features', 'allora');
    $filter_button_text    = esc_html__('Search', 'allora');
    $filter_label_cost     = esc_html__('Budget', 'allora');;

    // Determine minimum cost.
    $min_cost_query = new WP_Query(array(
        'post_type'         => 'property',
        'posts_per_page'    => 1,
        'meta_key'          => 'cost',
        'orderby'           => 'meta_value_num',
        'order'             => 'ASC',
        'meta_query'        => array(
            array(
                'key'     => 'cost',
                'compare' => 'EXISTS'
            )
        ),
        'fields'            => 'ids',
        'suppress_filters'  => false,
        'lang'              => allora_get_current_lang_code(),
    ));
    $default_cost_min = ($min_cost_query->have_posts())
        ? floatval(get_field('cost', $min_cost_query->posts[0]))
        : 0;
    wp_reset_postdata();

    // Determine maximum cost.
    $max_cost_query = new WP_Query(array(
        'post_type'         => 'property',
        'posts_per_page'    => 1,
        'meta_key'          => 'cost',
        'orderby'           => 'meta_value_num',
        'order'             => 'DESC',
        'meta_query'        => array(
            array(
                'key'     => 'cost',
                'compare' => 'EXISTS'
            )
        ),
        'fields'            => 'ids',
        'suppress_filters'  => false,
        'lang'              => allora_get_current_lang_code(),
    ));
    $default_cost_max = ($max_cost_query->have_posts())
        ? floatval(get_field('cost', $max_cost_query->posts[0]))
        : 999999999;
    wp_reset_postdata();

    // Fallback to defaults if cost values are not provided.
    if ($filter_cost_min === '') {
        $filter_cost_min = $default_cost_min;
    }
    if ($filter_cost_max === '') {
        $filter_cost_max = $default_cost_max;
    }

    // Get current page number.
    $paged = max(1, get_query_var('paged', 0));

    // Assemble filter data array.
    $filter_data = array(
        'filter_condition'      => $filter_condition,
        'filter_property_type'  => $filter_property_type,
        'filter_location'       => $filter_location,
        'filter_features'       => $filter_features,
        'filter_cost_min'       => $filter_cost_min,
        'filter_cost_max'       => $filter_cost_max,
        'conditions'            => get_unique_meta_values('condition'),
        'property_types'        => get_unique_meta_values('property_type'),
        'locations'             => get_unique_meta_values('location'),
        'features_arr'          => get_unique_meta_values('features'),
        'filter_all_conditions' => $filter_all_conditions,
        'filter_all_types'      => $filter_all_types,
        'filter_all_locations'  => $filter_all_locations,
        'filter_all_features'   => $filter_all_features,
        'filter_button_text'    => $filter_button_text,
        'filter_label_cost'     => $filter_label_cost,
        'default_cost_min'      => $default_cost_min,
        'default_cost_max'      => $default_cost_max,
        'paged'                 => $paged,
    );
    return $filter_data;
}