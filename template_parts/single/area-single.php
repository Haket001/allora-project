<?php
    $area_posts = new WP_Query(
        [
            'post_type' => 'area',
            'posts_per_page' => 4
        ]
    );
    ?>
<?php if (function_exists('the_breadcrumbs')) : ?>
    <?php the_breadcrumbs(); ?>
<?php endif; ?>
<?php the_post(); ?>
<div class="container">
    <article>
        <div class="post-image">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail(); ?>
            <?php else: ?>
                <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/no-image.png" alt="">
            <?php endif; ?>
        </div>
        <div class="content-container">
            <h1><?php the_title() ?></h1>
            <?php the_content() ?>
        </div>
    </article>
    <?php if ($area_posts->have_posts()): ?>
        <div class="area-content">
            <?php while ($area_posts->have_posts()): ?>
                <?php $area_posts->the_post(); ?>
                <article class="post">
                    <div class="post-image-wrap">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()): ?>
                                <?php echo get_the_post_thumbnail() ?>
                            <?php else: ?>
                                <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/no-image.png" alt="">
                            <?php endif; ?>
                        </a>
                    </div>
                    <h2><?php the_title() ?></h2>
                    <p>
                        <?php echo wp_trim_words(get_the_excerpt(), 43, ''); ?>
                    </p> 
                    <a class="post-link" href="<?php the_permalink(); ?>">
                        <?php echo esc_html__('READ', 'allora'); ?>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</div>