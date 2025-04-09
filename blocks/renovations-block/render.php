<?php
/**
 * Render template for RenovationsBlock
 */

$title = get_field("title");
$subtitle = get_field("subtitle");
$text = get_field("text");
$image = get_field("image");
?>

<section>
    <div class="container">
        <div class="renovations-form__wrap">
            <div class="renovations-form__wrap-text">
                <div class="renovations-form__image">
                    <img src="<?php echo esc_html($image); ?>" alt="">
                </div>
                <div class="renovations-form__text">
                    <h3><?php echo esc_html($title); ?></h3>
                    <strong><?php echo esc_html($subtitle); ?></strong>
                    <?php echo $text ?>
                </div>
            </div>
            <div class="renovations-form__form">
                <?php echo do_shortcode('[contact-form-7 id="00d625d" title="Renovations Form"]') ?>
            </div>
        </div>
    </div>
</section>