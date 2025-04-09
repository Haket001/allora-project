<?php
$slug = get_field("slug");
$why_elements = get_field("why_elements");
$counter = 1;
?>
<section class='why-section'>
	<div class='container'>
		<h4><?php echo esc_html($slug); ?></h4>
		<div class='why-wrap'>
			<?php if ($why_elements): ?>
				<?php foreach ($why_elements as $why_element): ?>
					<div class='why-element'>
						<span class='why-slug-wrap'>
							<strong><?php echo $counter; ?></strong>
							<span>
								<p><?php echo esc_html($why_element['why_subslug']); ?></p>
								<h5>
									<?php echo esc_html($why_element['why_slug']); ?>
								</h5>
							</span>
						</span>
						<p><?php echo wp_kses_post($why_element['why_text']); ?></p>
					</div>
					<?php $counter++; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>