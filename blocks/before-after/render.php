<?php

/**
 * Render template for BeforeAfter
 */

?>

<section class="before-after-slider">
    <div class="container">
        <div class="slider-wrap">
            <?php if (have_rows('sliders')): ?>
                <div class="swiper before-after-swiper">
                    <div class="swiper-wrapper">
                        <?php while (have_rows('sliders')): the_row();
                            $image_before = get_sub_field('image_before');
                            $image_after = get_sub_field('image_after');
                            if ($image_before && $image_after):
                        ?>
                                <div class="swiper-slide">
                                    <div class="beer-slider">
                                        <img src="<?php echo esc_url($image_before['url']); ?>" alt="<?php echo esc_attr($image_before['alt']); ?>">
                                        <div class="beer-reveal">
                                            <img src="<?php echo esc_url($image_after['url']); ?>" alt="<?php echo esc_attr($image_after['alt']); ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>