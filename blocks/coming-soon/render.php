<?php
/**
 * Render template for ComingSoon
 */

$title = get_field("title");
$text = get_field("text");
?>

<section class="coming-soon-section">
    <div class="container">
        <div class="coming-soon">
            <h1><?php echo esc_html($title) ?></h1>
            <p><?php echo esc_html(text: $text) ?></p>
        </div>
    </div>
</section>
