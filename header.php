<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>></body>
<header>
<script>
window.siteVars = window.siteVars || {};
window.siteVars.currentLang = '<?php echo allora_get_current_lang_code(); ?>';
</script>
	<nav class="header-wrap">
		<div class="container">
			<?php
            if (function_exists('the_custom_logo')) {
                the_custom_logo();
            }
            ?>
			<?php get_template_part('template_parts/global/menu') ?>
			<?php get_template_part('template_parts/global/header-content') ?>
		</div>
	</nav>
</header>
