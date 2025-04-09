<?php

/**
 * Рендер кастомного ACF блока
 */
function render_acf_block($block, $content = '', $is_preview = false, $post_id = 0) {
    $slug = str_replace('acf/', '', $block['name']);
    $block_dir = get_template_directory() . "/blocks/$slug";
    $block_json_path = "$block_dir/block.json";

    // Читаем block.json только если он существует
    static $block_cache = [];

    if (isset($block_cache[$slug])) {
        $block_json = $block_cache[$slug];
    } elseif (file_exists($block_json_path)) {
        $block_json_raw = file_get_contents($block_json_path);
        $block_json = json_decode($block_json_raw, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("ACF Block JSON decode error in {$slug}: " . json_last_error_msg());
            return;
        }

        $block_cache[$slug] = $block_json;
    } else {
        error_log("ACF Block block.json not found for {$slug}");
        return;
    }

    // Подключение стилей (enqueueStyle)
    if (!empty($block_json['enqueueStyle'])) {
        $styles = (array) $block_json['enqueueStyle'];

        foreach ($styles as $index => $style) {
            if (strpos($style, 'file:') === 0) {
                $style_file = str_replace('file:', '', $style);
                $style_path = realpath("$block_dir/$style_file");

                if ($style_path && file_exists($style_path)) {
                    wp_enqueue_style(
                        "acf-block-{$slug}-style-{$index}",
                        get_template_directory_uri() . "/blocks/{$slug}/" . ltrim($style_file, './'),
                        [],
                        filemtime($style_path)
                    );
                } else {
                    error_log("ACF Block style not found: {$block_dir}/{$style_file}");
                }
            }
        }
    }

    // Подключение скриптов (enqueueScript)
    if (!empty($block_json['enqueueScript'])) {
        $scripts = (array) $block_json['enqueueScript'];

        foreach ($scripts as $index => $script) {
            if (strpos($script, 'file:') === 0) {
                $script_file = str_replace('file:', '', $script);
                $script_path = realpath("$block_dir/$script_file");

                if ($script_path && file_exists($script_path)) {
                    wp_enqueue_script(
                        "acf-block-{$slug}-script-{$index}",
                        get_template_directory_uri() . "/blocks/{$slug}/" . ltrim($script_file, './'),
                        [],
                        filemtime($script_path),
                        true
                    );
                } else {
                    error_log("ACF Block script not found: {$block_dir}/{$script_file}");
                }
            }
        }
    }

    // Подключение editor-стилей только в редакторе
    if (is_admin() && !empty($block_json['enqueueEditorStyle'])) {
        $editor_styles = (array) $block_json['enqueueEditorStyle'];

        foreach ($editor_styles as $index => $editor_style) {
            if (strpos($editor_style, 'file:') === 0) {
                $editor_style_file = str_replace('file:', '', $editor_style);
                $editor_style_path = realpath("$block_dir/$editor_style_file");

                if ($editor_style_path && file_exists($editor_style_path)) {
                    wp_enqueue_style(
                        "acf-block-{$slug}-editor-style-{$index}",
                        get_template_directory_uri() . "/blocks/{$slug}/" . ltrim($editor_style_file, './'),
                        [],
                        filemtime($editor_style_path)
                    );
                } else {
                    error_log("ACF Block editor style not found: {$block_dir}/{$editor_style_file}");
                }
            }
        }
    }

    // Подключение PHP шаблона рендера
    $render_php = "$block_dir/render.php";

    if (file_exists($render_php)) {
        include $render_php;
    } else {
        error_log("ACF Block render.php not found for {$slug}");
    }
}

/**
 * Автоматическая регистрация всех ACF блоков
 */
function register_acf_blocks_autoload() {
    $blocks_dir = get_template_directory() . '/blocks/';

    foreach (glob($blocks_dir . '*', GLOB_ONLYDIR) as $block_path) {
        $block_json_path = $block_path . '/block.json';

        if (file_exists($block_json_path)) {
            $block_json_raw = file_get_contents($block_json_path);
            $block_json = json_decode($block_json_raw, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                register_block_type_from_metadata($block_path, [
                    'render_callback' => 'render_acf_block',
                ]);
            } else {
                error_log('ACF Block JSON decode error at ' . $block_path . ': ' . json_last_error_msg());
            }
        } else {
            error_log('ACF Block block.json missing at ' . $block_path);
        }
    }
}

add_action('init', 'register_acf_blocks_autoload');