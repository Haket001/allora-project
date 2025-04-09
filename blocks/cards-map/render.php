<?php

/**
 * Render template for CardsMap
 */

$map = get_field('map');
?>

<section>
    <div class="container">
        <div class="contnet-wrap">
            <?php if (have_rows('cards')): ?>
                <div class="cards-wrap">
                    <?php while (have_rows('cards')): the_row(); ?>
                        <?php
                        $image = get_sub_field('image');
                        $marker = get_sub_field('marker');
                        $slug = get_sub_field('slug');
                        $text = get_sub_field('text');
                        ?>
                        <div class="card">
                            <div class="img-card">
                                <img src="<?php echo esc_html($image) ?>" alt="">
                                <p><?php echo esc_html($marker) ?></p>
                            </div>
                            <div class="text-wrap">
                                <h2><?php echo esc_html($slug) ?></h2>
                                <hr>
                                <?php echo $text ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
            <div class="map-wrap">
                <img src="<?php echo esc_html($map) ?>" alt="">
            </div>
        </div>
    </div>
</section>