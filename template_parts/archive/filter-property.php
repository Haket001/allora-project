<?php
// Property Filter Template - displays the filter form using $filter_data
$filter_data = get_query_var('filter_data') ?: array();
?>
<div class="container">
    <div class="property-filter">
        <form class="property-filter-form" id="property-filter-form">
            <!-- Condition dropdown -->
            <div class="custom-select multi-select" data-name="condition" data-placeholder="<?php echo esc_attr($filter_data['filter_all_conditions']); ?>">
                <div class="custom-select-trigger">
                    <?php echo esc_html($filter_data['filter_all_conditions']); ?>
                    <div class="red-circle"></div>
                </div>
                <div class="custom-options">
                    <?php foreach ($filter_data['conditions'] as $cond): ?>
                        <?php
                        // Translate the condition value using WPML filter.
                        $translated_cond = apply_filters('wpml_translate_single_string', $cond, 'ACF Strings', $cond);
                        $cond_underscore = str_replace(' ', '_', $cond);
                        ?>
                        <label>
                            <input type="checkbox" name="condition[]" value="<?php echo esc_attr($cond_underscore); ?>"
                                <?php if (!empty($filter_data['filter_condition']) && in_array($cond_underscore, (array)$filter_data['filter_condition'])) {
                                    echo 'checked';
                                } ?>>
                            <?php echo esc_html($translated_cond); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Property Type dropdown -->
            <div class="custom-select multi-select" data-name="property_type" data-placeholder="<?php echo esc_attr($filter_data['filter_all_types']); ?>">
                <div class="custom-select-trigger">
                    <?php echo esc_html($filter_data['filter_all_types']); ?>
                    <div class="red-circle"></div>
                </div>
                <div class="custom-options">
                    <?php foreach ($filter_data['property_types'] as $pt): ?>
                        <?php 
                        // Translate the property type value using WPML filter
                        $translated_pt = apply_filters('wpml_translate_single_string', $pt, 'ACF Strings', $pt);
                        $pt_underscore = str_replace(' ', '_', $pt);
                        ?>
                        <label>
                            <input type="checkbox" name="property_type[]" value="<?php echo esc_attr($pt_underscore); ?>"
                                <?php if (!empty($filter_data['filter_property_type']) && in_array($pt_underscore, (array)$filter_data['filter_property_type'])) { echo 'checked'; } ?>>
                            <?php echo esc_html($translated_pt); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Location dropdown -->
            <div class="custom-select multi-select" data-name="location" data-placeholder="<?php echo esc_attr($filter_data['filter_all_locations']); ?>">
                <div class="custom-select-trigger">
                    <?php echo esc_html($filter_data['filter_all_locations']); ?>
                    <div class="red-circle"></div>
                </div>
                <div class="custom-options">
                    <?php foreach ($filter_data['locations'] as $location): ?>
                        <?php 
                        // Translate the location value using WPML filter
                        $translated_location = apply_filters('wpml_translate_single_string', $location, 'ACF Strings', $location);
                        $loc_underscore = str_replace(' ', '_', $location);
                        ?>
                        <label>
                            <input type="checkbox" name="location[]" value="<?php echo esc_attr($loc_underscore); ?>"
                                <?php if (!empty($filter_data['filter_location']) && in_array($loc_underscore, (array)$filter_data['filter_location'])) { echo 'checked'; } ?>>
                            <?php echo esc_html($translated_location); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Features dropdown -->
            <div class="custom-select multi-select" data-name="features" data-placeholder="<?php echo esc_attr($filter_data['filter_all_features']); ?>">
                <div class="custom-select-trigger">
                    <?php echo esc_html($filter_data['filter_all_features']); ?>
                    <div class="red-circle"></div>
                </div>
                <div class="custom-options">
                    <?php foreach ($filter_data['features_arr'] as $feat): ?>
                        <?php 
                        // Translate the feature value using WPML filter
                        $translated_feat = apply_filters('wpml_translate_single_string', $feat, 'ACF Strings', $feat);
                        $feat_underscore = str_replace(' ', '_', $feat);
                        ?>
                        <label>
                            <input type="checkbox" name="features[]" value="<?php echo esc_attr($feat_underscore); ?>"
                                <?php if (!empty($filter_data['filter_features']) && in_array($feat_underscore, (array)$filter_data['filter_features'])) { echo 'checked'; } ?>>
                            <?php echo esc_html($translated_feat); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Cost filter with slider -->
            <div class="custom-select cost-dropdown" data-placeholder="<?php echo esc_attr($filter_data['filter_label_cost']); ?>">
                <div class="custom-select-trigger">
                    <?php echo esc_html($filter_data['filter_label_cost']); ?>
                    <div class="red-circle"></div>
                </div>
                <div class="custom-options budget">
                    <div
                        id="cost-slider"
                        data-min="<?php echo esc_attr($filter_data['default_cost_min']); ?>"
                        data-max="<?php echo esc_attr($filter_data['default_cost_max']); ?>"></div>
                    <div class="cost-inputs">
                        <div class="input-wrap">
                            <input
                                type="text"
                                name="cost_min"
                                id="cost_min"
                                placeholder="Min"
                                value="<?php echo esc_attr($filter_data['filter_cost_min']); ?>"
                                oninput="updateFormatted(this)">
                            <span class="value">€</span>
                        </div>
                        <hr>
                        <div class="input-wrap">
                            <input
                                type="text"
                                name="cost_max"
                                id="cost_max"
                                placeholder="Max"
                                value="<?php echo esc_attr($filter_data['filter_cost_max']); ?>"
                                oninput="updateFormatted(this)">
                            <span class="value max">€</span>
                        </div>
                    </div>
                </div>
            </div>
            <button class="apply-filter" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M15.9888 15.425L12.1808 11.4645C13.1599 10.3006 13.6964 8.83611 13.6964 7.31156C13.6964 3.74957 10.7983 0.851562 7.23636 0.851562C3.67438 0.851562 0.776367 3.74957 0.776367 7.31156C0.776367 10.8735 3.67438 13.7716 7.23636 13.7716C8.57358 13.7716 9.84788 13.3682 10.9374 12.6026L14.7743 16.5932C14.9347 16.7597 15.1504 16.8516 15.3816 16.8516C15.6004 16.8516 15.8079 16.7681 15.9655 16.6165C16.3003 16.2943 16.311 15.7601 15.9888 15.425ZM7.23636 2.53678C9.86923 2.53678 12.0111 4.67869 12.0111 7.31156C12.0111 9.94443 9.86923 12.0863 7.23636 12.0863C4.60349 12.0863 2.46158 9.94443 2.46158 7.31156C2.46158 4.67869 4.60349 2.53678 7.23636 2.53678Z" fill="white" />
                </svg>
                <?php echo esc_html($filter_data['filter_button_text']); ?>
            </button>
        </form>
        <a target="_blank" class="match__link" href="https://forms.fillout.com/t/jHPdWXpF69us"><?php echo esc_html__('Match me', 'allora'); ?></a>
    </div>

    <div id="property-results" class="grid-container">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <?php get_template_part('template_parts/archive/content', 'property'); ?>
            <?php endwhile; ?>
    </div>
    <div id="pagination-wrapper">
        <?php
            if ($wp_query->max_num_pages > 1) {
                echo allora_get_property_pagination($wp_query, $_GET, max(1, get_query_var('paged')));
            }
        ?>
    </div>
<?php else: ?>
</div>
<p>No properties found.</p>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
</div>