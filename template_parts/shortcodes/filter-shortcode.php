<?php
/**
 * Dynamic Property Filter Shortcode
 * Outputs a filter form with dynamic options.
 */
function property_filter_shortcode( $atts ) {
    $filter_data = get_query_var('filter_data');
    if ( ! is_array( $filter_data ) ) {
        $filter_data = array(
            'filter_all_conditions' => 'Condition',
            'filter_all_types'      => 'Property Type',
            'filter_all_locations'  => 'Location',
            'filter_all_features'   => 'Features',
        );
    }
    
    $archive_url = trailingslashit( get_post_type_archive_link( 'property' ) );
    ob_start();
    ?>
    <form id="property-filter-shortcode-form" method="GET" action="<?php echo esc_url( $archive_url ); ?>">
        <!-- Condition filter (dynamic) -->
        <div class="filter-field">
            <label for="condition"><?php echo esc_html( $filter_data['filter_all_conditions'] ); ?>:</label>
            <select name="condition[]" id="condition" multiple>
                <?php 
                if ( ! empty( $filter_data['conditions'] ) && is_array( $filter_data['conditions'] ) ) :
                    foreach ( $filter_data['conditions'] as $cond ) : ?>
                        <option value="<?php echo esc_attr( $cond ); ?>"><?php echo esc_html( $cond ); ?></option>
                    <?php endforeach;
                endif;
                ?>
            </select>
        </div>
        <!-- Property Type filter (dynamic) -->
        <div class="filter-field">
            <label for="property_type"><?php echo esc_html( $filter_data['filter_all_types'] ); ?>:</label>
            <select name="property_type[]" id="property_type" multiple>
                <?php 
                if ( ! empty( $filter_data['property_types'] ) && is_array( $filter_data['property_types'] ) ) :
                    foreach ( $filter_data['property_types'] as $pt ) : ?>
                        <option value="<?php echo esc_attr( $pt ); ?>"><?php echo esc_html( $pt ); ?></option>
                    <?php endforeach;
                endif;
                ?>
            </select>
        </div>
        <!-- Location filter (dynamic) -->
        <div class="filter-field">
            <label for="location"><?php echo esc_html( $filter_data['filter_all_locations'] ); ?>:</label>
            <select name="location[]" id="location" multiple>
                <?php 
                if ( ! empty( $filter_data['locations'] ) && is_array( $filter_data['locations'] ) ) :
                    foreach ( $filter_data['locations'] as $loc ) : ?>
                        <option value="<?php echo esc_attr( $loc ); ?>"><?php echo esc_html( $loc ); ?></option>
                    <?php endforeach;
                endif;
                ?>
            </select>
        </div>
        <!-- Features filter (dynamic) -->
        <div class="filter-field">
            <label for="features"><?php echo esc_html( $filter_data['filter_all_features'] ); ?>:</label>
            <select name="features[]" id="features" multiple>
                <?php 
                if ( ! empty( $filter_data['features_arr'] ) && is_array( $filter_data['features_arr'] ) ) :
                    foreach ( $filter_data['features_arr'] as $feat ) : ?>
                        <option value="<?php echo esc_attr( $feat ); ?>"><?php echo esc_html( $feat ); ?></option>
                    <?php endforeach;
                endif;
                ?>
            </select>
        </div>
        <!-- Cost filter -->
        <div class="filter-field">
            <label for="cost_min">Min Cost:</label>
            <input type="number" name="cost_min" id="cost_min" placeholder="Min Cost" value="<?php echo isset( $filter_data['filter_cost_min'] ) ? esc_attr( $filter_data['filter_cost_min'] ) : ''; ?>">
            <label for="cost_max">Max Cost:</label>
            <input type="number" name="cost_max" id="cost_max" placeholder="Max Cost" value="<?php echo isset( $filter_data['filter_cost_max'] ) ? esc_attr( $filter_data['filter_cost_max'] ) : ''; ?>">
        </div>
        <!-- Hidden field for pagination -->
        <input type="hidden" name="paged" value="1">
        <button type="submit"><?php echo isset( $filter_data['filter_button_text'] ) ? esc_html( $filter_data['filter_button_text'] ) : 'Filter Properties'; ?></button>
    </form>
    <script>
    (function(){
        var form = document.getElementById('property-filter-shortcode-form');
        if(!form) return;
        form.addEventListener('change', function(e){
            if(e.target.name !== 'paged'){
                var pagedInput = form.querySelector('input[name="paged"]');
                if(pagedInput) {
                    pagedInput.value = '1';
                }
                var formData = new FormData(form);
                var params = new URLSearchParams(formData).toString();
                window.location.href = form.getAttribute('action') + '?' + params;
            }
        });
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('property_filter', 'property_filter_shortcode');