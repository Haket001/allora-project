<?php
require_once(dirname(__FILE__) . '/../../../../wp-load.php');

header('Content-Type: application/json');

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/weather-data', [
        'methods' => 'GET',
        'callback' => function () {
            $key = get_field('api_field', 'option');
            if (!$key) {
                return new WP_Error('no_key', 'API key missing', ['status' => 400]);
            }

            $city = isset($_GET['city']) ? sanitize_text_field($_GET['city']) : 'Puglia';
            $country = isset($_GET['country']) ? sanitize_text_field($_GET['country']) : 'IT';
            $cache_key = 'weather_data_' . md5($city . '_' . $country);

            $ip = $_SERVER['REMOTE_ADDR'] ?? null;
            $limit_key = 'weather_ip_limit_' . md5($ip);

            $rate_limited = false;
            if ($ip && get_transient($limit_key)) {
                $rate_limited = true;
            }

            $data = get_transient($cache_key);
            if (!$data) {
                if ($rate_limited) {
                    return new WP_Error('rate_limited', 'Too many requests. Cached data unavailable.', ['status' => 429]);
                }

                $url = "https://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&appid={$key}&units=metric";
                $response = wp_remote_get($url);
                if (is_wp_error($response)) {
                    return new WP_Error('weather_fetch_failed', 'Failed to fetch weather data', ['status' => 502]);
                }

                $data = json_decode(wp_remote_retrieve_body($response), true);
                if (!$data || !isset($data['main']['temp'])) {
                    return new WP_Error('invalid_weather_response', 'Invalid weather API response', ['status' => 500]);
                }

                set_transient($cache_key, $data, 15 * 60);
                if ($ip) {
                    set_transient($limit_key, true, 30);
                }
            }

            return [
                'temp' => round($data['main']['temp']),
            ];
        },
        'permission_callback' => '__return_true',
    ]);
});