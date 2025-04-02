<?php
$slug = get_field("slug");
$first_button = get_field("first_button");
$first_link = get_field("first_link");
$second_button = get_field("second_button");
$second_link = get_field("second_link");
?>
<section class='property-section'>
	<div class='container'>
		<h4><?php echo esc_html($slug) ?></h4>
		<div class='property-buttons-wrap'>
			<a class='gradient-button link-button dark open-filter-modal' href="#">
				<?php echo esc_html($first_button) ?>
			</a>
			<a target="_blank" class='gradient-button link-button light'
				href="<?php echo esc_url($second_link) ?>">
				<?php echo esc_html($second_button) ?>
			</a>
		</div>
		<?php
		$args = array(
			'post_type' => 'property',
			'posts_per_page' => 4,
			'orderby' => 'date',
			'order' => 'DESC',
			'lang' => apply_filters('wpml_current_language', null)
		);
		$query = new WP_Query($args);

		if ($query->have_posts()):
			echo '<div class="grid-container">';
			while ($query->have_posts()):
				$query->the_post();
				get_template_part('template_parts/archive/content', 'property');
			endwhile;
			echo '</div>';
			wp_reset_postdata();
		else:
			echo '<p>Not found.</p>';
		endif;
		?>
		<div id="filter-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <?php get_template_part('blocks/filter-form/render'); ?>
    </div>
</div>
	</div>
</section>