<?php

/**
 * Render template for RenovationsDescription
 */

$description = get_field("description");
?>

<section>
    <div class="container">
        <div class="property description">
            <h3><?php echo esc_html__('Description', 'Allora') ?></h3>
            <?php echo $description ?>
        </div>
    </div>
</section>