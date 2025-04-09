<?php
/**
 * Render template for BuyersBlock
 */

$text = get_field("text");
$button = get_field("button");

?>

<section>
    <div class="container">
        <div class="buyers-wrap">
            <p><?php echo esc_html($text) ?> </p>
            <a class="gradient-button" href="<?php echo esc_url($button['url']); ?>">
                <?php echo esc_html($button['title']); ?>
            </a>
        </div>
    </div>
</section>