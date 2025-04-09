<?php
$cost  = get_field("cost", get_the_ID());
$zip   = get_field("zip", get_the_ID());
$city  = get_field("city", get_the_ID());
$street= get_field("street", get_the_ID());
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('grid-item'); ?>>
    <div class="listing-style">
        <div class="list-thumb">
            <span class="cost">
                <?php
                if ($cost) {
                    $number = (float) $cost;
                    $formatted_cost = number_format($number, 0, ',', ' ');
                    echo '€ ' . $formatted_cost;
                } else {
                    echo esc_html__('Price on request', 'allora');
                }
                ?>
            </span>
            <a class="arrow-link" target="_blank" href="<?php the_permalink(); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M6.71753 0.206573L15.7175 0.206572C16.2698 0.206573 16.7175 0.654288 16.7175 1.20657L16.7175 10.2066C16.7175 10.7589 16.2698 11.2066 15.7175 11.2066C15.1652 11.2066 14.7175 10.7589 14.7175 10.2066L14.7175 3.62079L2.2825 16.0558L0.868286 14.6416L13.3033 2.20657L6.71753 2.20657C6.16524 2.20657 5.71753 1.75886 5.71753 1.20657C5.71753 0.654288 6.16524 0.206573 6.71753 0.206573Z"
                          fill="#2A3E57" />
                </svg>
            </a>
            <a class="image-link" href="<?php the_permalink(); ?>">
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail();
                } else {
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/no-image.png') . '" alt="' . get_the_title() . '">';
                }
                ?>
            </a>
        </div>
        <div class="list-content">
            <a href="<?php the_permalink(); ?>">
                <h6 class="list-title"><?php the_title(); ?></h6>
            </a>
            <!-- <span class="address"><?php echo $zip . ' ' . $city . ' ' . $street; ?></span> -->
        </div>
    </div>
</article>