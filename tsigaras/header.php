<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tsigaras
 */

$logo = get_theme_mod("tsigaras_header_logo", '');
$logo_mb = get_theme_mod("tsigaras_header_logo_mb", '');
$menu = get_theme_mod("tsigaras_header_menu", '');
$btn_text = get_theme_mod("tsigaras_header_btn_text", '');
$btn_url = get_theme_mod("tsigaras_header_btn_url", '');
$blog_page = is_archive() || is_author() || is_category() || is_home() || is_tag() || is_search();
$elementor_page = get_post_meta(get_the_ID(), '_elementor_edit_mode', true);




$social = !empty(get_theme_mod("global_settings_social_links")) ? get_theme_mod("global_settings_social_links") : '';
$social_array = explode(",", $social);
$social_names = ['twitter', 'linkedin', 'facebook', 'instagram', 'youtube', 'tiktok'];



?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

  <?php if (!$elementor_page || $blog_page) { ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <?php } ?>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <!-- MAIN_WRAPPER -->

  <?php wp_body_open(); ?>

  <!-- <div class="tsigaras-preloader"></div> -->

  <div class="tsigaras-global__social">
    <ul>
      <?php
      foreach ($social_array as $link) {
        foreach ($social_names as $name) {
          if (strpos($link, $name) !== false) {  ?>

            <li>
              <a href="<?= $link ?>" title="<?= $name ?>" aria-label="<?= $name ?>" target="_blank" rel="noopener">
                <?php echo file_get_contents(get_template_directory() . '/assets/image/' . $name . '.svg'); ?>
              </a>
            </li>
      <?php }
        }
      } ?>
    </ul>
  </div>


  <div class="tsigaras-main" id="tsigaras-main">
    <?php if (!is_404()) { ?>
      <header class="tsigaras-header">

        <!-- NAVIGATION -->
        <nav class="tsigaras-header__menu container">

          <div class="tsigaras-header__logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
              <?php if (isset($logo) && !empty($logo)) {
                echo wp_get_attachment_image($logo, 'full');
              } ?>
            </a>
          </div>

          <div class="tsigaras-header__wrap">
            <div class="tsigaras-header__logo mobile">
              <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php if (isset($logo_mb) && !empty($logo_mb)) {
                  echo wp_get_attachment_image($logo_mb, 'full');
                } ?>
              </a>
            </div>

            <div class="tsigaras-header__wrap-inner">


              <?php if (!empty($menu)) {
                $args = array('container' => '', 'menu' => $menu,);
                wp_nav_menu($args);
              } ?>

            </div>

            <?php
            if (!empty($btn_text) || !empty($btn_url)) { ?>
              <div class="tsigaras-header__btn">
                <img class="logo-footer_bottom" src="<?php echo get_template_directory_uri(); ?>/assets/image/icon-phone.png" alt="Icon Phone" loading="lazy">

                <div>
                  <span class="p-sm">Call us now</span>
                  <a href="<?php echo esc_url($btn_url); ?>"><?php echo esc_html($btn_text); ?></a>
                </div>
              </div>
            <?php } ?>
          </div>
          <!-- MOB MENU ICON -->
          <div class="tsigaras-header__mob-nav">
            <a href="#">
              <span></span>
              <span></span>
              <span></span>
            </a>
          </div>
        </nav>

      </header>
      <main class="tsigaras-main__wrap">

      <?php } ?>