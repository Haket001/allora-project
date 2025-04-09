<?php

/**
 * Render template for ArchiveTabs
 */

 $term_slugs = ['coast', 'town', 'valkey', 'inland'];
 ?>
 
 <div class="container">
     <div class="custom-tabs">
         <ul class="tab-nav">
             <?php foreach ($term_slugs as $index => $default_slug):
                 $term = get_term_by('slug', $default_slug, 'area_category');
                 if (!$term) continue;
 
                 $translated_term_id = apply_filters('wpml_object_id', $term->term_id, 'area_category', true);
                 $translated_term = get_term($translated_term_id, 'area_category');
                 if (!$translated_term) continue;
             ?>
                 <li data-tab="tab-<?= $index ?>" <?= $index === 0 ? 'class="active"' : '' ?>>
                     <?= esc_html($translated_term->name) ?>
                 </li>
             <?php endforeach; ?>
         </ul>
 
         <div class="tab-contents">
             <?php foreach ($term_slugs as $index => $default_slug):
                 $term = get_term_by('slug', $default_slug, 'area_category');
                 if (!$term) continue;
 
                 $translated_term_id = apply_filters('wpml_object_id', $term->term_id, 'area_category', true);
                 $translated_term = get_term($translated_term_id, 'area_category');
                 if (!$translated_term) continue;
 
                 $posts = get_posts([
                     'post_type' => 'area',
                     'numberposts' => 5,
                     'tax_query' => [[
                         'taxonomy' => 'area_category',
                         'field' => 'term_id',
                         'terms' => $translated_term->term_id,
                     ]],
                     'lang' => '',
                 ]);
             ?>
                 <div class="tab-content <?= $index === 0 ? 'active' : '' ?>" id="tab-<?= $index ?>">
                     <?php if ($posts): ?>
                         <?php foreach ($posts as $post): setup_postdata($post); ?>
                             <article class="post">
                                 <div class="post-image-wrap">
                                     <a href="<?php the_permalink($post->ID); ?>">
                                         <?php if (has_post_thumbnail($post)): ?>
                                             <?= get_the_post_thumbnail($post) ?>
                                         <?php else: ?>
                                             <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/no-image.png" alt="">
                                         <?php endif; ?>
                                     </a>
                                 </div>
                                 <h2><?= get_the_title($post) ?></h2>
                                 <p><?php $content = get_the_content(); 
                                echo wp_trim_words( $content, 43, '' );?>
                                </p>                                <a class="post-link" href="<?php the_permalink($post->ID); ?>">
                                     <?= esc_html__('READ', 'allora'); ?>
                                 </a>
                             </article>
                         <?php endforeach;
                         wp_reset_postdata(); ?>
                     <?php else: ?>
                         <p><?= esc_html__('No posts in this category.', 'allora') ?></p>
                     <?php endif; ?>
                 </div>
             <?php endforeach; ?>
         </div>
     </div>
 </div>