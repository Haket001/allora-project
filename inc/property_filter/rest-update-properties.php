<?php

if (!function_exists('allora_get_current_lang_code')) {
    require_once get_template_directory() . '/inc/property_filter/property-filter-logic.php';
}

// Register REST route for filtering properties
add_action('rest_api_init', function () {
    register_rest_route('allora/v1', '/filter-properties/', array(
        'methods'             => 'GET',
        'callback'            => 'filter_properties_rest',
        'permission_callback' => '__return_true'
    ));
});

/**
 * Build meta_query array based on filter parameters.
 *
 * @param array $params Request parameters.
 * @return array
 */
function allora_build_meta_query($params) {
    $meta_query = array('relation' => 'AND');
    $fields = array('features', 'condition', 'property_type', 'location');

    foreach ($fields as $field) {
        if (!empty($params[$field])) {
            if (!is_array($params[$field])) {
                $params[$field] = array_map('trim', explode(',', sanitize_text_field($params[$field])));
            }
            // Convert underscores to spaces
            $params[$field] = array_map(function ($val) {
                return str_replace('_', ' ', $val);
            }, $params[$field]);

            // Build subqueries with array_map & array_filter
            $subqueries = array_filter(array_map(function($val) use ($field) {
                return $val !== '' ? array(
                    'key'     => $field,
                    'value'   => $val,
                    'compare' => 'LIKE'
                ) : null;
            }, $params[$field]));

            if (!empty($subqueries)) {
                $meta_query[] = array(
                    'relation' => 'AND',
                    array(
                        'key'     => $field,
                        'compare' => 'EXISTS'
                    ),
                    array_merge(array('relation' => 'OR'), $subqueries)
                );
            }
        }
    }

    // Cost range filtering
    if ($params['cost_min'] !== '' || $params['cost_max'] !== '') {
        $cost_min = $params['cost_min'] !== '' ? floatval($params['cost_min']) : 0;
        $cost_max = $params['cost_max'] !== '' ? floatval($params['cost_max']) : 999999999;

        // Check if cost_min or cost_max were explicitly changed by user
        $cost_min_explicit = (isset($_GET['cost_min']) && $_GET['cost_min'] !== '');
        $cost_max_explicit = (isset($_GET['cost_max']) && $_GET['cost_max'] !== '');

        if ($cost_min_explicit || $cost_max_explicit) {
            // If the user explicitly provided cost_min or cost_max, exclude posts without a cost
            $meta_query[] = array(
                'key'     => 'cost',
                'value'   => array($cost_min, $cost_max),
                'type'    => 'NUMERIC',
                'compare' => 'BETWEEN',
            );
        } else {
            // If cost parameters are not explicitly provided, include posts without cost
            $meta_query[] = array(
                'relation' => 'OR',
                array(
                    'key'     => 'cost',
                    'value'   => array($cost_min, $cost_max),
                    'type'    => 'NUMERIC',
                    'compare' => 'BETWEEN',
                ),
                array(
                    'key'     => 'cost',
                    'compare' => 'NOT EXISTS',
                )
            );
        }
    }
    return $meta_query;
}

/**
 * REST callback for filtering properties.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function filter_properties_rest($request) {
    $params = $request->get_params();
    $meta_query = allora_build_meta_query($params);
    $paged = isset($params['paged']) ? intval($params['paged']) : 1;

    $query_args = array(
        'post_type'      => 'property',
        'posts_per_page' => 12,
        'paged'          => $paged,
        'meta_query'     => $meta_query,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'lang'           => allora_get_current_lang_code() // Make sure WPML sees the language
    );

    $query = new WP_Query($query_args);

    if ($paged > $query->max_num_pages && $query->max_num_pages > 0) {
        $paged = 1;
        $query_args['paged'] = 1;
        $query = new WP_Query($query_args);
    }

    $cache_key = 'allora_filter_' . md5(serialize($params));
    $cached_response = get_transient($cache_key);
    if ($cached_response !== false) {
        return rest_ensure_response($cached_response);
    }

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template_parts/archive/content', 'property');
        }
    } else {
        echo '<p>No properties found.</p>';
    }
    $properties_html = ob_get_clean();

    $pagination_html = '';
    if ($query->max_num_pages > 1) {
        global $wp_query;
        $old_query = $wp_query;
        $wp_query = $query;
        $pagination_html = allora_get_property_pagination($query, $params, $paged);
        $wp_query = $old_query;
    }
    wp_reset_postdata();

    $response_data = array(
        'html'       => $properties_html,
        'pagination' => $pagination_html
    );

    set_transient($cache_key, $response_data, 604800);
    return rest_ensure_response($response_data);
}

/**
 * Modify the main query for the property archive.
 */
function modify_property_archive_query($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('property')) {
        $params = array(
            'condition'     => get_query_var('condition'),
            'property_type' => get_query_var('property_type'),
            'location'      => get_query_var('location'),
            'features'      => get_query_var('features'),
            'cost_min'      => get_query_var('cost_min'),
            'cost_max'      => get_query_var('cost_max')
        );
        $meta_query = allora_build_meta_query($params);
        $query->set('orderby', 'date');
        $query->set('order', 'DESC');
        $query->set('posts_per_page', 12);
        
        if (count($meta_query) > 1) {
            $query->set('meta_query', $meta_query);
        }
    }
}
add_action('pre_get_posts', 'modify_property_archive_query');

/**
 * Flush filter cache when a property is updated or deleted.
 */
function flush_allora_filter_cache($post_id) {
    if (get_post_type($post_id) !== 'property') return;
    global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_allora_filter_%'");
    // Also flush unique meta values cache
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_allora_unique_meta_%'");
}
add_action('save_post', 'flush_allora_filter_cache');
add_action('delete_post', 'flush_allora_filter_cache');

/**
 * Redirect to page 1 if requested page exceeds available pages.
 */
add_action('template_redirect', function () {
    if (is_admin()) return;
    global $wp_query;
    if (!$wp_query->is_main_query()) return;
    if (empty($wp_query->query['post_type']) || $wp_query->query['post_type'] !== 'property') return;
    $paged_requested = get_query_var('paged');
    if ($paged_requested > 1 && $wp_query->max_num_pages > 0 && $paged_requested > $wp_query->max_num_pages) {
        $args = array_merge($wp_query->query_vars, ['paged' => 1]);
        query_posts($args);
    }
}, 20);

add_action('init', 'allora_register_property_filter_rewrites');
function allora_register_property_filter_rewrites() {
    add_rewrite_tag('%condition%', '([^/]+)');
    add_rewrite_tag('%property_type%', '([^/]+)');
    add_rewrite_tag('%location%', '([^/]+)');
    add_rewrite_tag('%features%', '([^/]+)');
    add_rewrite_tag('%cost_min%', '([^/]+)');
    add_rewrite_tag('%cost_max%', '([^/]+)');

    add_rewrite_rule(
        '^properties(?:/condition-([^/]+))?(?:/property_type-([^/]+))?(?:/location-([^/]+))?(?:/features-([^/]+))?(?:/cost_min-([^/]+))?(?:/cost_max-([^/]+))?/?(?:page/([0-9]+))?/?$',
        'index.php?post_type=property&condition=$matches[1]&property_type=$matches[2]&location=$matches[3]&features=$matches[4]&cost_min=$matches[5]&cost_max=$matches[6]&paged=$matches[7]',
        'top'
    );
}