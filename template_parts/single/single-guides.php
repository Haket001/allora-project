<article>
    <div class="container">
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
    </div>
</article>