<?php
// Function for adding new fields in selectors for properties with WPML translation support.
function populate_dynamic_field($field) {
    $config = array(
        'condition' => array(
            'repeater'  => 'conditions_options',
            'sub_field' => 'condition_value'
        ),
        'city' => array(
            'repeater'  => 'city_options',
            'sub_field' => 'city_value'
        ),
        'property_type' => array(
            'repeater'  => 'property_type_options',
            'sub_field' => 'property_type_value'
        ),
        'features' => array(
            'repeater'  => 'features_options',
            'sub_field' => 'features_value'
        ),
        'location' => array(
            'repeater'  => 'location_options',
            'sub_field' => 'location_value'
        ),
    );

    $field_name = $field['name'];

    if (!isset($config[$field_name])) {
        return $field;
    }

    $field['choices'] = array();
    $repeater = $config[$field_name]['repeater'];
    $sub_field = $config[$field_name]['sub_field'];

    if (have_rows($repeater, 'option')) {
        while (have_rows($repeater, 'option')) {
            the_row();
            $item = get_sub_field($sub_field);
			if ($item) {
				do_action('wpml_register_single_string', 'ACF Strings', $item, $item);
				$translated_value = apply_filters('wpml_translate_single_string', $item, 'ACF Strings', $item);
				$field['choices'][$item] = $translated_value;
			}
        }
    }
	
    return $field;
	
}

add_action('admin_init', function() {
    if (have_rows('conditions_options', 'option')) {
        while (have_rows('conditions_options', 'option')) {
            the_row();
            $item = get_sub_field('condition_value');
            if ($item) {
                do_action('wpml_register_single_string', 'ACF Strings', $item, $item);
            }
        }
    }
	if (have_rows('city_options', 'option')) {
		while (have_rows('city_options', 'option')) {
			the_row();
			$item = get_sub_field('city_value');
			if ($item) {
				do_action('wpml_register_single_string', 'ACF Strings', $item, $item);
			}
		}
	}
	if (have_rows('property_type_options', 'option')) {
		while (have_rows('property_type_options', 'option')) {
			the_row();
			$item = get_sub_field('property_type_value');
			if ($item) {
				do_action('wpml_register_single_string', 'ACF Strings', $item, $item);
			}
		}
	}
	if (have_rows('features_options', 'option')) {
		while (have_rows('features_options', 'option')) {
			the_row();
			$item = get_sub_field('features_value');
			if ($item) {
				do_action('wpml_register_single_string', 'ACF Strings', $item, $item);
			}
		}
	}
	if (have_rows('location_options', 'option')) {
		while (have_rows('location_options', 'option')) {
			the_row();
			$item = get_sub_field('location_value');
			if ($item) {
				do_action('wpml_register_single_string', 'ACF Strings', $item, $item);
			}
		}
	}
});

function translate_acf_field_value($value, $post_id, $field) {
    if (!empty($value)) {
        $value = apply_filters('wpml_translate_single_string', $value, 'ACF Strings', $value);
    }
    return $value;
}

add_filter('acf/load_value/name=condition', 'translate_acf_field_value', 10, 3);
add_filter('acf/load_value/name=city', 'translate_acf_field_value', 10, 3);
add_filter('acf/load_value/name=property_type', 'translate_acf_field_value', 10, 3);
add_filter('acf/load_value/name=features', 'translate_acf_field_value', 10, 3);
add_filter('acf/load_value/name=location', 'translate_acf_field_value', 10, 3);