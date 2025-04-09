<?php
$guides_posts = new WP_Query(
    [
        'post_type' => 'guides',
    ]
);
?>
<section>
    <div class="container">
        <div class="guides-container">
            <h1><?php echo esc_html__('Guides', 'Allora') ?></h1>
            <?php if ($guides_posts->have_posts()): ?>
                <div class="guides-wrap">
                    <?php while ($guides_posts->have_posts()): ?>
                        <?php $guides_posts->the_post(); ?>
                        <article class="post">
                            <div class="post-image-wrap">
                                <a class="img-link" href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php echo get_the_post_thumbnail() ?>
                                    <?php else: ?>
                                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/no-image.png" alt="">
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="post-content">
                                <h2><?php the_title() ?></h2>
                                <p>
                                    <?php echo wp_trim_words(get_the_content(), 89, ''); ?>
                                </p>
                                <a class="post-link" href="<?php the_permalink(); ?>">
                                    <?php echo esc_html__('More', 'allora'); ?>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>