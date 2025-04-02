<?php
if (!function_exists('allora_get_property_pagination')) {
    function allora_get_property_pagination($query, $params = array(), $paged = 1) {
        global $wp_query;
        $old_query = $wp_query;
        $wp_query = $query;

        function implode_if_array($val) {
            if (is_array($val)) {
                return implode(',', array_map('trim', $val));
            }
            return trim($val);
        }

        // condition
        $conditionVal     = !empty($params['condition']) ? implode_if_array($params['condition']) : '';
        // property_type
        $propertyTypeVal  = !empty($params['property_type']) ? implode_if_array($params['property_type']) : '';
        // location
        $locationVal      = !empty($params['location']) ? implode_if_array($params['location']) : '';
        // features
        $featuresVal      = '';
        if (!empty($params['features'])) {
            $arr = is_array($params['features']) ? $params['features'] : explode(',', $params['features']);
            $arr = array_map(function($item){
                return str_replace(' ', '_', trim($item));
            }, $arr);
            $featuresVal = implode(',', $arr);
        }
        // cost_min, cost_max
        $costMinVal = isset($params['cost_min']) ? trim($params['cost_min']) : '';
        $costMaxVal = isset($params['cost_max']) ? trim($params['cost_max']) : '';

        $segments = array();
        if ($conditionVal !== '') {
            $segments[] = 'condition-' . $conditionVal;
        }
        if ($propertyTypeVal !== '') {
            $segments[] = 'property_type-' . $propertyTypeVal;
        }
        if ($locationVal !== '') {
            $segments[] = 'location-' . $locationVal;
        }
        if ($featuresVal !== '') {
            $segments[] = 'features-' . $featuresVal;
        }
        if ($costMinVal !== '') {
            $segments[] = 'cost_min-' . $costMinVal;
        }
        if ($costMaxVal !== '') {
            $segments[] = 'cost_max-' . $costMaxVal;
        }

        $base = '/properties';
        if (count($segments) > 0) {
            $base .= '/' . implode('/', $segments);
        }
        $base = trailingslashit($base) . 'page/%#%/';

        $args = array(
            'base'      => $base,
            'format'    => '',
            'total'     => $query->max_num_pages,
            'current'   => max(1, $paged),
            'prev_text' => '<',
            'next_text' => '>',
            'echo'      => false,
        );

        $pagination_html = get_the_posts_pagination($args);
        $wp_query = $old_query;
        return $pagination_html;
    }
}