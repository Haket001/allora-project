<?php
/**
 * Render template for FilterForm
 */

$filter_data = function_exists('allora_get_filter_data') 
    ? allora_get_filter_data() 
    : array(
        'filter_all_conditions' => __('Condition', 'allora'),
        'filter_all_types'      => __('Property Type', 'allora'),
        'filter_all_locations'  => __('Location', 'allora'),
        'filter_all_features'   => __('Features', 'allora'),
        'filter_button_text'    => __('Search', 'allora'),
        'filter_label_cost'     => __('Budget', 'allora'),
        'conditions'            => array(),
        'property_types'        => array(),
        'locations'             => array(),
        'features_arr'          => array(),
        'filter_cost_min'       => '',
        'filter_cost_max'       => '',
        'default_cost_min'      => 0,
        'default_cost_max'      => 999999999,
    );
?>


    <div class="property-filter">
        <p class="heading"><?php echo esc_html__('Browse', 'Allora') ?></p>
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
                        // Translate condition value via WPML
                        $translated_cond = apply_filters('wpml_translate_single_string', $cond, 'ACF Strings', $cond);
                        $cond_underscore = str_replace(' ', '_', $cond);
                        ?>
                        <label>
                            <input type="checkbox" name="condition[]" value="<?php echo esc_attr($cond_underscore); ?>">
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
                        $translated_pt = apply_filters('wpml_translate_single_string', $pt, 'ACF Strings', $pt);
                        $pt_underscore = str_replace(' ', '_', $pt);
                        ?>
                        <label>
                            <input type="checkbox" name="property_type[]" value="<?php echo esc_attr($pt_underscore); ?>">
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
                        $translated_location = apply_filters('wpml_translate_single_string', $location, 'ACF Strings', $location);
                        $loc_underscore = str_replace(' ', '_', $location);
                        ?>
                        <label>
                            <input type="checkbox" name="location[]" value="<?php echo esc_attr($loc_underscore); ?>">
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
                        $translated_feat = apply_filters('wpml_translate_single_string', $feat, 'ACF Strings', $feat);
                        $feat_underscore = str_replace(' ', '_', $feat);
                        ?>
                        <label>
                            <input type="checkbox" name="features[]" value="<?php echo esc_attr($feat_underscore); ?>">
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
                    <div id="cost-slider" data-min="<?php echo esc_attr($filter_data['default_cost_min']); ?>" data-max="<?php echo esc_attr($filter_data['default_cost_max']); ?>"></div>
                    <div class="cost-inputs">
                        <div class="input-wrap">
                            <input type="text" name="cost_min" id="cost_min" placeholder="Min" value="<?php echo esc_attr($filter_data['filter_cost_min']); ?>" oninput="updateFormatted(this)">
                            <span class="value">€</span>
                        </div>
                        <hr>
                        <div class="input-wrap">
                            <input type="text" name="cost_max" id="cost_max" placeholder="Max" value="<?php echo esc_attr($filter_data['filter_cost_max']); ?>" oninput="updateFormatted(this)">
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
    </div>

<script>
// JavaScript for collecting filter data and redirecting to archive URL
(function() {
    const form = document.getElementById('property-filter-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Collect selected conditions
        const condChecks = [...form.querySelectorAll('input[name="condition[]"]:checked')]
            .map(ch => ch.value.trim())
            .filter(Boolean);
        // Collect selected property types
        const propTypeChecks = [...form.querySelectorAll('input[name="property_type[]"]:checked')]
            .map(ch => ch.value.trim())
            .filter(Boolean);
        // Collect selected locations
        const locChecks = [...form.querySelectorAll('input[name="location[]"]:checked')]
            .map(ch => ch.value.trim())
            .filter(Boolean);
        // Collect selected features
        const featChecks = [...form.querySelectorAll('input[name="features[]"]:checked')]
            .map(ch => ch.value.trim())
            .filter(Boolean);

        const costMin = (form.querySelector('#cost_min') || {}).value || '';
        const costMax = (form.querySelector('#cost_max') || {}).value || '';

        const segments = [];
        if (condChecks.length) {
            segments.push('condition-' + condChecks.join(','));
        }
        if (propTypeChecks.length) {
            segments.push('property_type-' + propTypeChecks.join(','));
        }
        if (locChecks.length) {
            segments.push('location-' + locChecks.join(','));
        }
        if (featChecks.length) {
            segments.push('features-' + featChecks.join(','));
        }
        if (costMin) {
            segments.push('cost_min-' + costMin);
        }
        if (costMax) {
            segments.push('cost_max-' + costMax);
        }

        // Determine language prefix using siteVars (WPML)
        let langPrefix = '';
        const defaultLang = 'en';
        if (window.siteVars && window.siteVars.currentLang) {
            const currentLang = window.siteVars.currentLang;
            if (currentLang !== defaultLang) {
                langPrefix = '/' + currentLang;
            }
        }
        let finalUrl = langPrefix + '/properties';
        if (segments.length > 0) {
            finalUrl += '/' + segments.join('/');
        }
        finalUrl += '/';
        window.location.href = finalUrl;
    });
})();
</script>