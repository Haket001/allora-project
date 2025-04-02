<div class="weather">
	<p>
		<?php
        $weather_city = get_field('weather_city', 'option');
        echo $weather_city;
        ?>
	</p>
	<span id="weather-time"></span>
</div>
<div class="header-buttons">
	<a class="rounded-link" href="#">For sellers</a>
    <?php
$languages = apply_filters('wpml_active_languages', null, ['skip_missing' => 0, 'orderby' => 'code']);

if (!empty($languages)) {
    ?>
    <div class="custom-select-wrapper">
        <div class="custom-select" id="languageSwitcher">
            <div class="custom-select-trigger">
                <?php
                foreach ($languages as $lang) {
                    if ($lang['active']) {
                        echo strtoupper(esc_html($lang['language_code']));                        break;
                    }
                }
                ?>
            </div>
            <div class="custom-options">
                <?php
                foreach ($languages as $lang) {
                    echo '<span class="custom-option" data-value="' . esc_url($lang['url']) . '">';
                    echo esc_html($lang['language_code']);
                    echo '</span>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>
</div>