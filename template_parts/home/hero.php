<section class="hero-section">
    <?php
    $video_url = get_field('video_field');
    if ($video_url): ?>
        <video autoplay loop muted playsinline class="video-background">
            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
        </video>
    <?php endif; ?>
    <div class="hero-content">
        <div class="logo">
            <svg width="350" height="109" viewBox="0 0 350 109" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="$dark-primary" />
                <path fill="$yellow" />
                <path fill="white" />
                <path fill="white" />
                <path fill="white" />
                <path fill="white" />
            </svg>
        </div>
        <h1><?php the_field('hero_tiitle') ?></h1>
        <h2><?php the_field('hero_tiitle_second') ?></h2>
        <div class="hero-links">
            <a href="#" class="link">browse</a>
            <a href="#" class="link second">Match Me</a>
        </div>
    </div>
    <div class="container hero-socials">
        <p>Let`s Connect!</p>
        <a class='rounded-socials' href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                viewBox="0 0 24 25" fill="none">
                <path fill="$dark-primary" />
                <path fill="$dark-primary" />
            </svg></a>
        <a class='rounded-socials' href="#"><svg width="14" height="26" viewBox="0 0 14 26" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill="$dark-primary" />
            </svg>
        </a>
        <a class='rounded-socials' href="#"><svg width="22" height="16" viewBox="0 0 22 16" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill="$dark-primary" />
            </svg>
        </a>
    </div>
</section>x