<?php
$reasons = get_field("reasons");
$slug = get_field("slug");
?>
<section class="reasons-section">
	<div class="container">
		<h4><?php echo esc_html($slug); ?></h4>
		<div class="reasons-wrap">
			<?php if ($reasons): ?>
				<?php foreach ($reasons as $reason): ?>
					<div class="reason">
						<div class="rounded-square">
							<?php
							$svg_url = $reason['picture'];
							if ($svg_url) {
								$svg_path = str_replace(site_url(), ABSPATH, $svg_url);
								if (file_exists($svg_path)) {
									echo file_get_contents($svg_path);
								} else {
									echo '<img src="' . esc_url($svg_url) . '" alt="">';
								}
							}
							?>
						</div>
						<h5><?php echo esc_html($reason['reason_slug']); ?></h5>
						<p><?php echo wp_kses_post($reason['reason_text']); ?></p>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>