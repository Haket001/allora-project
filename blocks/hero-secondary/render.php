<?php
/**
 * Render template for HeroSecondary
 */

$hero_image = get_field("hero_image");
?>
<section class="hero-section">
    <div class="container-fluid">
        <div class="hero-image" style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.30) 0%, rgba(0, 0, 0, 0.30) 100%), url(<?php echo esc_html($hero_image); ?>) lightgray 0px -131.64px / 100% 150.607% no-repeat;;">
            <h1><?php echo get_the_title() ?></h1>
        </div>
    </div>
</section>