<?php

/**
 * Tsigaras functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Tsigaras
 */

defined('TSIGARAS_T_URI') or define('TSIGARAS_T_URI', get_template_directory_uri());
defined('TSIGARAS_T_PATH') or define('TSIGARAS_T_PATH', get_template_directory());

require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once TSIGARAS_T_PATH . '/include/actions-config.php';
require_once TSIGARAS_T_PATH . '/include/helper-function.php';
require_once TSIGARAS_T_PATH . '/include/customizer.php';
require_once TSIGARAS_T_PATH . '/include/site-options.php';
require_once TSIGARAS_T_PATH . '/cmb2/init.php';
require_once TSIGARAS_T_PATH . '/include/cmb2-conditionals.php';


// Elementor widgets
if (defined('ELEMENTOR_VERSION')) {
  include_once TSIGARAS_T_PATH . '/include/elementor-widgets.php';
}

if (!function_exists('tsigaras_setup')) :

  function tsigaras_setup()
  {

    load_theme_textdomain('tsigaras', get_template_directory() . '/languages');

    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('post-formats', array(
      'aside',
      'gallery',
      'link',
      'image',
      'quote',
      'status',
      'video',
      'audio',
      'chat'
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('title-tag');
    add_theme_support('menus');
  }
endif;

add_action('after_setup_theme', 'tsigaras_setup');

// Disable REST API link tag
remove_action('wp_head', 'rest_output_link_wp_head', 10);

//Rel attribute for styles
if (!function_exists('tsigaras_add_rel_preload')) {
  function tsigaras_add_rel_preload($html, $handle, $href, $media)
  {

    if (is_admin()) {
      return $html;
    }

    $html = <<<EOT
<link rel="preload stylesheet preconnect" as="style" id="$handle" href="$href" type="text/css" media="$media" crossorigin />
EOT;


    return $html;
  }
  add_filter('style_loader_tag',  'tsigaras_add_rel_preload', 10, 4);
}

//Support for SVG
if (!function_exists('tsigaras_mime_types')) {
  function tsigaras_mime_types($mimes)
  {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }

  add_filter('upload_mimes', 'tsigaras_mime_types');
}

//Remove JQuery migrate
if (!function_exists('liberate_remove_jquery_migrate')) {
  function liberate_remove_jquery_migrate($scripts)
  {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
      $script = $scripts->registered['jquery'];
      if ($script->deps) {
        // Check whether the script has any dependencies

        $script->deps = array_diff($script->deps, array('jquery-migrate'));
      }
    }
  }

  add_action('wp_default_scripts', 'liberate_remove_jquery_migrate');
}
