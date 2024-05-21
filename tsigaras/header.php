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

          <div class="tsigaras-header__logo mobile">
            <a href="<?php echo esc_url(home_url('/')); ?>">
              <?php if (isset($logo) && !empty($logo)) {
                echo wp_get_attachment_image($logo, 'full');
              } ?>
            </a>
          </div>

          <div class="tsigaras-header__wrap">
            <div class="tsigaras-header__logo desktop">
              <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php if (isset($logo) && !empty($logo)) {
                  echo wp_get_attachment_image($logo, 'full');
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
                <svg width="22" height="36" viewBox="0 0 22 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g clip-path="url(#clip0_96_39)">
                    <path d="M18.6276 0.0878906C19.1815 0.326254 19.7844 0.480489 20.2681 0.809992C21.3197 1.5391 21.7614 2.61174 21.7544 3.88769C21.7474 7.91883 21.7544 11.957 21.7544 15.9881C21.7544 20.2577 21.7544 24.5202 21.7544 28.7897C21.7544 29.9114 21.7614 31.0261 21.7544 32.1478C21.7474 34.3842 20.198 35.9195 17.9616 35.9195C13.2855 35.9195 8.60934 35.9195 3.93321 35.9195C2.1595 35.9195 0.715301 34.7908 0.343735 33.0872C0.266617 32.7367 0.252595 32.3721 0.252595 32.0076C0.245585 23.763 0.245585 15.5254 0.245585 7.28086C0.245585 6.15214 0.273628 5.01641 0.238574 3.88769C0.189499 1.98078 1.53555 0.403372 3.28121 0.136965C3.31627 0.129955 3.34431 0.108923 3.37235 0.0878906C8.46211 0.0878906 13.5449 0.0878906 18.6276 0.0878906ZM20.3032 7.29488C14.0777 7.29488 7.88724 7.29488 1.71783 7.29488C1.71783 14.4668 1.71783 21.5967 1.71783 28.7266C7.9293 28.7266 14.1127 28.7266 20.3032 28.7266C20.3032 21.5616 20.3032 14.4318 20.3032 7.29488ZM20.2962 30.1988C14.0777 30.1988 7.89425 30.1988 1.70381 30.1988C1.70381 31.005 1.66175 31.7832 1.72484 32.5614C1.75288 32.926 1.92815 33.3046 2.13847 33.613C2.60118 34.286 3.30225 34.4823 4.09445 34.4823C8.70048 34.4753 13.3065 34.4823 17.9125 34.4753C18.0738 34.4753 18.235 34.4613 18.4033 34.4473C19.3918 34.3562 20.2331 33.5499 20.2962 32.5614C20.3382 31.7902 20.2962 31.005 20.2962 30.1988ZM1.70381 5.8016C7.92229 5.8016 14.1057 5.8016 20.2962 5.8016C20.2962 4.98836 20.3102 4.19616 20.2891 3.40395C20.2821 3.17961 20.198 2.94825 20.0928 2.73793C19.6442 1.84757 18.88 1.51106 17.9125 1.51106C13.3065 1.51807 8.70048 1.51106 4.09445 1.51807C3.93321 1.51807 3.77196 1.53209 3.60371 1.54611C2.60819 1.63725 1.77392 2.43647 1.71082 3.43199C1.66876 4.21018 1.70381 4.99537 1.70381 5.8016Z" fill="white" />
                    <path d="M11.014 31.6288C11.4136 31.6358 11.7151 31.9513 11.7081 32.3509C11.7011 32.7295 11.3856 33.0379 11.014 33.0449C10.6284 33.052 10.2989 32.7224 10.2989 32.3369C10.2989 31.9302 10.6144 31.6218 11.014 31.6288Z" fill="white" />
                    <path d="M11.035 2.95526C11.4767 2.95526 11.9184 2.94825 12.3601 2.95526C12.8298 2.96227 13.1453 3.26372 13.1453 3.67034C13.1453 4.06995 12.8438 4.3644 12.3881 4.37141C11.4697 4.38543 10.5443 4.38543 9.62589 4.37141C9.15617 4.3644 8.8477 4.04893 8.86173 3.64231C8.87575 3.22868 9.19123 2.95525 9.66796 2.94824C10.1237 2.94824 10.5793 2.95526 11.035 2.95526Z" fill="white" />
                  </g>
                  <defs>
                    <clipPath id="clip0_96_39">
                      <rect width="22" height="35.8947" fill="white" transform="translate(0 0.0527344)" />
                    </clipPath>
                  </defs>
                </svg>

                <div>
                  <span class="p-sm">Call for appointment</span>
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