<?php
/**
 * Render template for TitleRenovations
 */

$subtitle = get_field("subtitle");
?>
<h1><?php echo the_title() ?></h1>
<h2><?php echo esc_html($subtitle) ?></h2>