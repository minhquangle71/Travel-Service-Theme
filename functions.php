<?php

function theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'primary' => 'Primary Menu',
    ]);
}
add_action('after_setup_theme', 'theme_setup');

function theme_assets()
{
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();
    $manifest_path = $theme_dir . '/assets/dist/.vite/manifest.json';

    if (defined('WP_DEBUG') && WP_DEBUG) {
        $vite_port = getenv('VITE_PORT') ?: '5173';
        $vite_host = getenv('VITE_HOST') ?: '127.0.0.1';
        $vite_protocol = getenv('VITE_PROTOCOL') ?: 'http';
        $vite_dev_server = $vite_protocol . '://' . $vite_host . ':' . $vite_port;

        wp_enqueue_script('travelservice-vite-client', $vite_dev_server . '/@vite/client', [], null, true);
        wp_enqueue_script('travelservice-main-js', $vite_dev_server . '/assets/src/main.js', [], null, true);

        return;
    }

    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);
        $entry = $manifest['assets/src/main.js'] ?? null;

        if ($entry && !empty($entry['file'])) {
            if (!empty($entry['css']) && is_array($entry['css'])) {
                foreach ($entry['css'] as $index => $css_file) {
                    wp_enqueue_style(
                        'travelservice-main-css-' . $index,
                        $theme_uri . '/assets/dist/' . $css_file,
                        [],
                        null
                    );
                }
            }

            wp_enqueue_script(
                'travelservice-main-js',
                $theme_uri . '/assets/dist/' . $entry['file'],
                [],
                null,
                true
            );

            return;
        }
    }

    wp_enqueue_style('travelservice-fallback-style', $theme_uri . '/style.css', [], wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'theme_assets');

function travelservice_module_scripts($tag, $handle, $src)
{
    $module_handles = [
        'travelservice-vite-client',
        'travelservice-main-js',
    ];

    if (in_array($handle, $module_handles, true)) {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }

    return $tag;
}
add_filter('script_loader_tag', 'travelservice_module_scripts', 10, 3);
