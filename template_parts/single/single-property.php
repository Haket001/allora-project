<?php
$fields = [
    'cost' => get_field("cost", get_the_ID()),
    'zip' => get_field("zip", get_the_ID()),
    'city' => get_field("city", get_the_ID()),
    'street' => get_field("street", get_the_ID()),
    'reference' => get_field("reference", get_the_ID()),
    'condition' => get_field("condition", get_the_ID()),
    'property_type' => get_field("property_type", get_the_ID()),
    'location' => get_field("location", get_the_ID()),
    'features' => get_field("features", get_the_ID()),
    'bedrooms' => get_field("bedrooms", get_the_ID()),
    'bathrooms' => get_field("bathrooms", get_the_ID()),
    'area' => get_field("area", get_the_ID()),
    'year_built' => get_field("year_built", get_the_ID()),
    'key_features' => get_field("key_features", get_the_ID()),
    'floor_plans' => get_field("floor_plans", get_the_ID()),
];

$fields['formatted_cost'] = $fields['cost'] ? number_format((float) $fields['cost'], 0, ',', ',') : esc_html__('Price on request', 'allora');

$characteristics = array_filter([
    ['field' => $fields['condition'], 'label' => __('Condition', 'allora'), 'icon' => 'terms-and-conditions.svg'],
    ['field' => $fields['property_type'], 'label' => __('Property Type', 'allora'), 'icon' => 'home.svg'],
    ['field' => $fields['location'], 'label' => __('Location', 'allora'), 'icon' => 'location.svg'],
    ['field' => $fields['features'], 'label' => __('Required Features', 'allora'), 'icon' => 'lighting-bulb.svg'],
    ['field' => $fields['bedrooms'], 'label' => __('Bedrooms', 'allora'), 'icon' => 'bed.svg'],
    ['field' => $fields['bathrooms'], 'label' => __('Bathrooms', 'allora'), 'icon' => 'bath.svg'],
    ['field' => $fields['area'], 'label' => __('Area', 'allora'), 'icon' => 'maximize.svg'],
    ['field' => $fields['year_built'], 'label' => __('Year Built', 'allora'), 'icon' => 'calender.svg'],
    ['field' => '€ ' . $fields['formatted_cost'], 'label' => __('Price', 'allora'), 'icon' => 'offer.svg'],
], fn($char) => !empty($char['field']));

?>
<div class="container">
    <article>
        <h1><?php the_title(); ?></h1>
        <div class="info-line">
            <!-- <span class="address"><?php echo implode(' ', array_filter([$fields['zip'], $fields['city'], $fields['street']])); ?></span> -->
            <span><?php echo esc_html__('Reference number', 'allora') . ': ' . esc_html($fields['reference']); ?></span>
        </div>


        <?php
        $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $images = get_field('gallery', get_the_ID()) ?: [];
        ?>
        <?php if (!empty($featured_image)): ?>
            <section class="gallery-wrap">
                <div class="property-gallery">
                    <div class="main-image">
                        <a href="<?php echo esc_url($featured_image); ?>" data-fancybox="gallery" id="main-image-link">
                            <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" id="main-image">
                        </a>
                    </div>
                <?php else: ?>
                    <div style="width: 100%; margin-bottom: 15px;" class="main-image">
                        <img style="width: 100%;" src="<?= get_stylesheet_directory_uri() ?>/assets/images/no-image.png" alt="">
                    </div>
                <?php endif; ?>
                <?php if (!empty($featured_image)): ?>
                    <div class="thumbnails">
                        <?php
                        echo '<div class="img-wrap"><a href="' . esc_url($featured_image) . '" data-fancybox="gallery"><img src="' . esc_url($featured_image) . '" alt="' . esc_attr(get_the_title()) . '"></a></div>';
                        echo implode('', array_map(fn($image) => '<div class="img-wrap"><a href="' . esc_url($image) . '" data-fancybox="gallery"><img src="' . esc_url($image) . '" alt="' . esc_attr(get_the_title()) . '"></a></div>', $images));
                        ?>
                    </div>
                </div>
            </section>
        <?php else: ?>
        <?php endif; ?>

        <div class="article-body__wrap">
            <div class="article__body">
                <ul class="characteristics property">
                    <?php foreach ($characteristics as $char): ?>
                        <li class="characteristics__item">
                            <div class="characteristics__image">
                                <?php
                                $svg_path = get_template_directory() . '/assets/images/' . $char['icon'];
                                if (file_exists($svg_path)) {
                                    echo file_get_contents($svg_path);
                                }
                                ?>
                            </div>
                            <div class="characteristics__title-wrap">
                                <p class="characteristics__title"><?php echo esc_html($char['label']); ?></p>
                                <p class="characteristics__value"><?php echo esc_html($char['field']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if (!empty($fields['key_features'])): ?>
                    <div class="property key-features">
                        <h2><?php echo esc_html__('Key Features', 'Allora') ?></h2>
                        <p><?php echo $fields['key_features']; ?></p>
                    </div>
                <?php endif; ?>
                <?php
                $content = get_the_content();
                if (!empty(trim($content))): ?>
                    <div class="property description">
                        <h3><?php echo esc_html__('Description', 'Allora') ?></h3>
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($fields['floor_plans'])): ?>
                    <div class="property floor-plans">
                        <h4><?php echo esc_html__('Floor Plans', 'Allora') ?></h4>
                        <img src="<?php echo esc_html($fields['floor_plans']); ?>" alt="">
                    </div>
                <?php endif; ?>
            </div>
            <div class="article__sidebar">
                <h3><?php echo esc_html__('Match me', 'allora'); ?></h3>
                <p><?php echo esc_html__('Fill out the questionnaire and we will send you offers based on it.', 'allora'); ?></p>
                <a target="_blank" class="gradient-button" href="https://forms.fillout.com/t/jHPdWXpF69us"><?php echo esc_html__('Match me', 'allora'); ?></a>
            </div>
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
    </article>
</div>