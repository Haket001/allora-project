<?php
$slug = get_field("slug");
$tabs = get_field("tabs");
$tabCounter = 1;
?>
<section class='accordion-section'>
	<div class='container'>
		<div class='accordion-block-wrap'>
			<h4><?php echo esc_html($slug) ?></h4>
			<div class='accordion-wrap'>
				<?php if (!empty($tabs) && is_array($tabs)): ?>
				<?php foreach ($tabs as $tab): ?>
				<div class="tab">
					<input type="checkbox" name="accordion-1" id="<?php echo 'cb' . $tabCounter; ?>">
					<?php if (!empty($tab['tab_slug'])): ?>
					<label for="<?php echo 'cb' . $tabCounter; ?>" class="tab__label">
						<?php echo esc_html($tab['tab_slug']); ?>
					</label>
					<?php endif; ?>
					<div class="tab__content">
						<?php if (!empty($tab['tab_text'])): ?>
						<p><?php echo esc_html($tab['tab_text']); ?></p>
						<?php endif; ?>
					</div>
				</div>
				<?php $tabCounter++; ?>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>