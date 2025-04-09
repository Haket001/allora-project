<?php
/**
 * Block template for AboutTeam
 */

$slug = get_field(selector: "slug");
$image = get_field("image");
$strong_text = get_field(selector: "strong_text");
$button_link = get_field("button_link");
$button_text = get_field("button_text");
$right_text = get_field("right_text");
?>

<section class="about-team">
    <div class="container">
        <h4><?php echo esc_html__($slug) ?></h4>
        <div class="image-wrap">
            <img src="<?php echo esc_html__($image) ?>" alt="">
        </div>
        <div class="text-wrap">
            <div class="left__text">
                <strong>
                    <?php echo esc_html__($strong_text) ?>
                </strong>
                <a class="gradient-button link-button dark" href="<?php echo esc_html__($button_link) ?>">
                    <?php echo esc_html__($button_text) ?>
                </a>
            </div>
            <div class="right__text">
                <?php echo $right_text ?>
            </div>
        </div>
    </div>
</section>