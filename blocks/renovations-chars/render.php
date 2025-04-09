<?php

/**
 * Render template for RenovationsChars
 */

$fields = [
    'cost' => get_field("cost"),
    'zip' => get_field("zip"),
    'city' => get_field("city"),
    'street' => get_field("street"),
    'reference' => get_field("reference"),
    'condition' => get_field("condition"),
    'property_type' => get_field("property_type"),
    'location' => get_field("location"),
    'feauters' => get_field("feauters"),
    'bedrooms' => get_field("bedrooms"),
    'bathrooms' => get_field("bathrooms"),
    'area' => get_field("area"),
    'year_built' => get_field("year_built"),
    'key_features' => get_field("key_features"),
    'floor_plans' => get_field("floor_plans"),
];


$fields['formatted_cost'] = $fields['cost'] ? number_format((float) $fields['cost'], 0, ',', ',') : esc_html__('Price on request', 'allora');

$characteristics = array_filter([
    ['field' => $fields['condition'], 'label' => __('Condition', 'allora'), 'icon' => 'terms-and-conditions.svg'],
    ['field' => $fields['property_type'], 'label' => __('Property Type', 'allora'), 'icon' => 'home.svg'],
    ['field' => $fields['location'], 'label' => __('Location', 'allora'), 'icon' => 'location.svg'],
    ['field' => $fields['feauters'], 'label' => __('Required Features', 'allora'), 'icon' => 'lighting-bulb.svg'],
    ['field' => $fields['bedrooms'], 'label' => __('Bedrooms', 'allora'), 'icon' => 'bed.svg'],
    ['field' => $fields['bathrooms'], 'label' => __('Bathrooms', 'allora'), 'icon' => 'bath.svg'],
    ['field' => $fields['area'], 'label' => __('Area', 'allora'), 'icon' => 'maximize.svg'],
    ['field' => $fields['year_built'], 'label' => __('Year Built', 'allora'), 'icon' => 'calender.svg'],
    ['field' => '€ ' . $fields['formatted_cost'], 'label' => __('Price', 'allora'), 'icon' => 'offer.svg'],
], fn($char) => !empty($char['field']));

?>

<section>
    <div class="container">
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
    </div>
</section>