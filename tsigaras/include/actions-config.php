<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Tsigaras
 */

add_action('after_setup_theme', 'tsigaras_content_width', 0);
add_action('wp_enqueue_scripts', 'tsigaras_enqueue_scripts', 999);
add_action('enqueue_block_editor_assets', 'tsigaras_add_gutenberg_assets');

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function tsigaras_body_classes($classes)
{
  // Adds a class of hfeed to non-singular pages.
  if (!is_singular()) {
    $classes[] = 'tsigaras-page';
  }

  return $classes;
}

add_filter('body_class', 'tsigaras_body_classes');


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function tsigaras_content_width()
{
  $GLOBALS['content_width'] = apply_filters('tsigaras_content_width', 1200);
}


/**
 * Enqueue scripts and styles.
 */
function tsigaras_enqueue_scripts()
{

  // general settings
  if ((is_admin())) {
    return;
  }

  if (is_page() || is_home()) {
    $post_id = get_queried_object_id();
  } else {
    $post_id = get_the_ID();
  }

  $blog_page = is_archive() || is_author() || is_category() || is_home() || is_tag() || is_search();
  $elementor_page = get_post_meta($post_id, '_elementor_edit_mode', true);

  if ($elementor_page) {
    wp_dequeue_style('wp-block-library'); // Wordpress core
    wp_dequeue_style('wp-block-library-theme'); // Wordpress core
    wp_dequeue_style('wc-block-style'); // WooCommerce
  }

  wp_enqueue_style('fancybox', TSIGARAS_T_URI . '/assets/css/lib/fancybox.css');
  wp_enqueue_style('tsigaras-general', TSIGARAS_T_URI . '/assets/css/general.min.css');

  if (!$elementor_page || $blog_page) {
    wp_enqueue_style('tsigaras-typography', TSIGARAS_T_URI . '/assets/css/typography.min.css');
  }

  if (is_404() && !$elementor_page) {
    wp_enqueue_style('tsigaras-error-page', TSIGARAS_T_URI . '/assets/css/error-page.min.css');
  }

  if ($blog_page) {
    wp_enqueue_style('tsigaras-blog-list', TSIGARAS_T_URI . '/assets/css/blog-list.min.css');
  }

  if (is_single()) {
    wp_enqueue_style('tsigaras-blog-single', TSIGARAS_T_URI . '/assets/css/blog-single.min.css');
  }

  wp_enqueue_style('tsigaras-main-style', TSIGARAS_T_URI . '/assets/css/style.min.css');
  wp_enqueue_style('tsigaras-style', TSIGARAS_T_URI . '/style.css');

  // add TinyMCE style
  add_editor_style();

  if (is_singular()) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('swiper', TSIGARAS_T_URI . '/assets/js/lib/swiper.js', array(), '', true);
  wp_enqueue_script('tsigaras-navigation', TSIGARAS_T_URI . '/assets/js/navigation.min.js', array(), '', true);
  wp_enqueue_script('tsigaras-skip-link-focus-fix', TSIGARAS_T_URI . '/assets/js/lib/skip-link-focus-fix.js', array(), '', true);


  wp_enqueue_script('fancybox', TSIGARAS_T_URI . '/assets/js/lib/fancybox.js', array('jquery'), '', true);
  wp_enqueue_script('tsigaras-script', TSIGARAS_T_URI . '/assets/js/script.min.js', array('jquery'), '', true);

  // including jQuery plugins
  wp_localize_script(
    'tsigaras-script',
    'get',
    array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'siteurl' => get_template_directory_uri(),
    )
  );

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}


/**
 * Add backend styles for Gutenberg.
 */

if (!function_exists('tsigaras_add_gutenberg_assets')) {
  function tsigaras_add_gutenberg_assets()
  {
    wp_enqueue_style('tsigaras-gutenberg', TSIGARAS_T_URI . '/assets/css/gutenberg.css');
  }
}


remove_action('wp_head', 'rest_output_link_wp_head', 10);

remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
remove_filter('render_block', 'wp_render_layout_support_flag', 10, 2);


function remove_dashicons_style()
{
  wp_dequeue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'remove_dashicons_style', 100);


add_action('init', function () {
  wp_register_script('custom-blocks-js', get_template_directory_uri() . '/assets/js/admin/custom-blocks.min.js');

  register_block_type('tsigaras/overview', [
    'editor_script' => 'custom-blocks-js',
  ]);
});


add_action('enqueue_block_editor_assets', 'enqueue_custom_blocks_styles');

function enqueue_custom_blocks_styles()
{
  wp_enqueue_style('custom-blocks-css', get_template_directory_uri() . '/assets/css/custom-blocks.min.css');
}
