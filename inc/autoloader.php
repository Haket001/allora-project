<?php
function render_acf_block($block, $content = '', $is_preview = false, $post_id = 0) {
	$slug = str_replace('acf/', '', $block['name']);
	$block_dir = get_template_directory() . "/blocks/$slug";

	$style_path = "$block_dir/style.css";
	if (file_exists($style_path)) {
		wp_enqueue_style(
			"acf-block-$slug",
			get_template_directory_uri() . "/blocks/$slug/style.css",
			[],
			filemtime($style_path)
		);
	}

	$script_path = "$block_dir/script.js";
	if (file_exists($script_path)) {
		wp_enqueue_script(
			"acf-block-script-$slug",
			get_template_directory_uri() . "/blocks/$slug/script.js",
			[],
			filemtime($script_path),
			true
		);
	}

	$editor_style_path = "$block_dir/editor.css";
	if (is_admin() && file_exists($editor_style_path)) {
		wp_enqueue_style(
			"acf-block-editor-$slug",
			get_template_directory_uri() . "/blocks/$slug/editor.css",
			[],
			filemtime($editor_style_path)
		);
	}

	$render_php = "$block_dir/render.php";
	if (file_exists($render_php)) {
		include $render_php;
	}
}

function register_acf_blocks_autoload() {
	$blocks_dir = get_template_directory() . '/blocks/';

	foreach (glob($blocks_dir . '*', GLOB_ONLYDIR) as $block_path) {
		if (file_exists($block_path . '/block.json')) {
			register_block_type($block_path, [
				'render_callback' => 'render_acf_block',
			]);
		}
	}
}
add_action('init', 'register_acf_blocks_autoload');
