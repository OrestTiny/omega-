<?php
defined('ABSPATH') || exit;

if (!function_exists('tsigaras_theme_options')) {

  function tsigaras_theme_options($wp_customize)
  {

    $wp_customize->add_section('global_settings', array(
      'title' => esc_html__('Global Settings', 'tsigaras')
    ));

    $wp_customize->add_setting(
      'global_settings_social_links',
      array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'tsigaras_sanitize_url'
      )
    );

    $wp_customize->add_control(new Tsigaras_Sortable_Repeater_Custom_Control(
      $wp_customize,
      'global_settings_social_links',
      array(
        'label' => esc_html__('Social Links', 'tsigaras'),
        'description' => esc_html__('Add your social links.', 'tsigaras'),
        'section' => 'global_settings',
        'button_labels' => array(
          'add' => esc_html__('Add New', 'tsigaras'),
        )
      )
    ));

    // HEADER SETTINGS

    $wp_customize->add_section('header_settings', array(
      'title' => esc_html__('Header Settings', 'tsigaras')
    ));

    $wp_customize->add_setting('tsigaras_header_logo', array(
      'sanitize_callback' => 'absint',
      'validate_callback' => 'tsigaras_validate_image',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'tsigaras_header_logo', array(
      'label' => esc_html__('Logo', 'tsigaras'),
      'section' => 'header_settings',
      'mime_type' => 'image',
    )));

    $menus = wp_get_nav_menus();
    $nav_menus = array();
    if (!isset($menus) || empty($menus)) {
      $nav_menus = ['' => esc_html__('No Menu', 'tsigaras')];
    } else {
      foreach ($menus as $menu) {
        $nav_menus[$menu->slug] = $menu->name;
      }
    }

    $wp_customize->add_setting('tsigaras_header_menu', array(
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'tsigaras_sanitize_select',
      'default' => '',
    ));

    $wp_customize->add_control('tsigaras_header_menu', array(
      'type' => 'select',
      'section' => 'header_settings',
      'label' => esc_html__('Menu', 'tsigaras'),
      'choices' => $nav_menus,
    ));



    $wp_customize->add_setting('tsigaras_header_btn_text', array(
      'capability' => 'edit_theme_options',
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('tsigaras_header_btn_text', array(
      'type' => 'text',
      'section' => 'header_settings',
      'label' => esc_html__('Button Text', 'tsigaras'),
    ));

    $wp_customize->add_setting('tsigaras_header_btn_url', array(
      'capability' => 'edit_theme_options',
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('tsigaras_header_btn_url', array(
      'type' => 'text',
      'section' => 'header_settings',
      'label' => esc_html__('Button URL', 'tsigaras'),
    ));


    // FOOTER SETTINGS

    $wp_customize->add_section('footer_settings', array(
      'title' => esc_html__('Footer Settings', 'tsigaras')
    ));

    // headline

    $wp_customize->add_setting('tsigaras_footer_shortcode', array(
      'capability' => 'edit_theme_options',
      'default' => '',
      'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('tsigaras_footer_shortcode', array(
      'type' => 'text',
      'section' => 'footer_settings',
      'label' => esc_html__('Shortcode Inst', 'tsigaras'),
    ));


    // phone 

    $wp_customize->add_setting('tsigaras_footer_phone', array(
      'capability' => 'edit_theme_options',
      'default' => '1-888-899-1255',
      'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('tsigaras_footer_phone', array(
      'type' => 'text',
      'section' => 'footer_settings',
      'label' => esc_html__('Phone Number', 'tsigaras'),
    ));

    // email 

    $wp_customize->add_setting('tsigaras_footer_email', array(
      'capability' => 'edit_theme_options',
      'default' => 'example@email.com',
      'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('tsigaras_footer_email', array(
      'type' => 'text',
      'section' => 'footer_settings',
      'label' => esc_html__('Email', 'tsigaras'),
    ));

    // 404 ERROR SETTINGS

    $wp_customize->add_section('error_settings', array(
      'title' => esc_html__('404 Error Settings', 'tsigaras')
    ));

    $wp_customize->add_setting('tsigaras_error_bg', array(
      'sanitize_callback' => 'absint',
      'validate_callback' => 'tsigaras_validate_image',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'tsigaras_error_bg', array(
      'label' => esc_html__('Background image', 'tsigaras'),
      'section' => 'error_settings',
      'mime_type' => 'image',
    )));

    $wp_customize->add_setting('tsigaras_error_description', array(
      'capability' => 'edit_theme_options',
      'default' => '',
      'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('tsigaras_error_description', array(
      'type' => 'textarea',
      'section' => 'error_settings',
      'label' => esc_html__('Description', 'tsigaras'),
    ));
  }

  add_action('customize_register', 'tsigaras_theme_options');
}
