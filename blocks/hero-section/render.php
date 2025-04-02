<?php
$video_file = get_field('video_field');
$hero_title = get_field('hero_tiitle');
$hero_subtitle = get_field('hero_tiitle_second');
$hero_logo = get_field('hero_logo');
$social_links = get_field('social_links');
$first_link = get_field('first_link');
$second_link = get_field('second_link');
?>

<section class="hero-section">
	<?php if (!empty($video_file)): ?>
	<video autoplay loop muted playsinline class="video-background">
		<source src="<?php echo esc_url($video_file); ?>" type="video/mp4">
	</video>
	<?php endif; ?>

	<div class="hero-content">
		<div class="logo">
			<img src="<?php echo esc_html($hero_logo) ?>" alt="">
		</div>
		<h1><?php echo esc_html($hero_title); ?></h1>
		<h5><?php echo esc_html($hero_subtitle); ?></h5>
		<div class="hero-links">
			<a href="<?php echo esc_html($first_link['url']); ?>" class="link"><?php echo esc_html($first_link['title']); ?></a>
			<a target="_blank" href="<?php echo esc_html($second_link['url']); ?>" class="link second"><?php echo esc_html($second_link['title']); ?></a>
		</div>
	</div>
	<div class="container">
		<div class="hero-socials">
			<p>Let’s Connect!</p>
			<?php if (!empty($social_links)): ?>
			<?php foreach ($social_links as $link): ?>
			<a class="rounded-socials" href="<?php echo esc_url($link['social_url']); ?>">
				<?php if (!empty($link['social_icon'])): ?>
				<img src="<?php echo esc_url($link['social_icon']); ?>" alt="Social Icon">
				<?php endif; ?>
			</a>
			<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>