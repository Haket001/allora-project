<?php
function enable_breadcrumbs()
{
    if (is_singular()) {
        global $post;
        if ($post && get_post_meta($post->ID, '_disable_breadcrumbs', true) == 1) {
            return false;
        }
    }
    return apply_filters('enable_breadcrumbs', true);
}

function add_breadcrumbs_meta_box()
{
    $screens = array('page', 'post', 'property'); // Specify post types for the meta box
    foreach ($screens as $screen) {
        add_meta_box(
            'breadcrumbs_meta',
            'Breadcrumbs',
            'breadcrumbs_meta_box_callback',
            $screen,
            'side'
        );
    }
}
add_action('add_meta_boxes', 'add_breadcrumbs_meta_box');

function breadcrumbs_meta_box_callback($post)
{
    wp_nonce_field('save_breadcrumbs_meta_box_data', 'breadcrumbs_meta_box_nonce');
    $value = get_post_meta($post->ID, '_disable_breadcrumbs', true);
    ?>
<label for="disable_breadcrumbs_checkbox">
    <input type="checkbox" name="disable_breadcrumbs" id="disable_breadcrumbs_checkbox" value="1"
        <?php checked($value, 1); ?> />
    <?php esc_html_e('Disable Breadcrumbs', 'your-textdomain'); ?>
</label>
<?php
}

function save_breadcrumbs_meta_box_data($post_id)
{
    if (!isset($_POST['breadcrumbs_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['breadcrumbs_meta_box_nonce'], 'save_breadcrumbs_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $value = isset($_POST['disable_breadcrumbs']) ? 1 : 0;
    update_post_meta($post_id, '_disable_breadcrumbs', $value);
}
add_action('save_post', 'save_breadcrumbs_meta_box_data');

function get_breadcrumbs_html()
{
    if (!enable_breadcrumbs()) {
        return '';
    }

    // Adapt breadcrumbs to WPML by filtering URLs if available.
    $home_url = function_exists('icl_object_id') ? apply_filters('wpml_permalink', home_url('/')) : home_url('/');
    $html = '<div class="container"><nav class="breadcrumbs">';
    $html .= '<a href="' . esc_url($home_url) . '">' . esc_html(__('Home', 'your-textdomain')) . '</a>';

    if (is_front_page() || is_home()) {
        // Do nothing
    } elseif (is_single()) {
        $post_type = get_post_type();
        if ($post_type && $post_type !== 'post') {
            $post_type_obj = get_post_type_object($post_type);
            if ($post_type_obj && !empty($post_type_obj->has_archive)) {
                $archive_link = get_post_type_archive_link($post_type);
                $archive_link = function_exists('icl_object_id') ? apply_filters('wpml_permalink', $archive_link) : $archive_link;
                $html .= ' / <a href="' . esc_url($archive_link) . '">' . esc_html($post_type_obj->labels->name) . '</a>';
            }
        } elseif ('post' === $post_type) {
            $blog_page_id = get_option('page_for_posts');
            if ($blog_page_id) {
                $blog_page = get_post($blog_page_id);
                if ($blog_page) {
                    $blog_permalink = function_exists('icl_object_id') ? apply_filters('wpml_permalink', get_permalink($blog_page_id)) : get_permalink($blog_page_id);
                    $html .= ' / <a href="' . esc_url($blog_permalink) . '">' . esc_html($blog_page->post_title) . '</a>';
                }
            } else {
                $blog_link = function_exists('icl_object_id') ? apply_filters('wpml_permalink', home_url('/blog')) : home_url('/blog');
                $html .= ' / <a href="' . esc_url($blog_link) . '">Blog</a>';
            }
        }
        $html .= ' <span>/</span> <span>' . get_the_title() . '</span>';
    } elseif (is_archive()) {
        if (is_category() || is_tag() || is_tax()) {
            $html .= ' <span>/</span> <span>' . single_term_title('', false) . '</span>';
        } elseif (is_post_type_archive()) {
            $post_type = get_query_var('post_type');
            if (!$post_type) {
                $post_type = 'post';
            }
            $post_type_obj = get_post_type_object($post_type);
            if ($post_type_obj) {
                $html .= ' <span>/</span> <span>' . esc_html($post_type_obj->labels->name) . '</span>';
            }
        } else {
            $html .= ' <span>/</span> <span>' . wp_title('', false) . '</span>';
        }
    } elseif (is_page()) {
        global $post;
        if ($post->post_parent) {
            $ancestors = get_post_ancestors($post);
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                $ancestor_link = function_exists('icl_object_id') ? apply_filters('wpml_permalink', get_permalink($ancestor)) : get_permalink($ancestor);
                $html .= ' / <a href="' . esc_url($ancestor_link) . '">' . get_the_title($ancestor) . '</a>';
            }
        }
        $html .= ' <span>/</span> <span>' . get_the_title() . '</span>';
    } else {
        $html .= ' <span>/</span> <span>' . wp_title('', false) . '</span>';
    }

    $html .= '</nav></div>';
    return $html;
}

function the_breadcrumbs()
{
    echo get_breadcrumbs_html();
}

function enqueue_breadcrumbs_style()
{
    if (enable_breadcrumbs() && (is_single() || is_archive() || is_page())) {
        wp_enqueue_style('breadcrumbs-style', get_template_directory_uri() . '/assets/styles/breadcrumbs.css', array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_breadcrumbs_style');