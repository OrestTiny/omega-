<?php

if (!function_exists('tsigaras_widgets_categories')) {
  function tsigaras_widgets_categories($elements_manager)
  {
    $elements_manager->add_category(
      'tsigaras',
      [
        'title' => esc_html__('Tsigaras Theme', 'tsigaras'),
        'icon' => 'dashicons-screenoptions'
      ]
    );
  }

  add_action('elementor/elements/categories_registered', 'tsigaras_widgets_categories', 99);
}

if (!class_exists('Tsigaras_Elementor_Widgets')) {
  class Tsigaras_Elementor_Widgets
  {

    protected static $instance = null;

    public static function get_instance()
    {
      if (!isset(static::$instance)) {
        static::$instance = new static;
      }

      return static::$instance;
    }

    protected function __construct()
    {
      require_once TSIGARAS_T_PATH . '/widgets/buttons/buttons.php';
      require_once TSIGARAS_T_PATH . '/widgets/slider-fade/slider-fade.php';
      require_once TSIGARAS_T_PATH . '/widgets/slider-main/slider-main.php';
      require_once TSIGARAS_T_PATH . '/widgets/single-video/single-video.php';
      require_once TSIGARAS_T_PATH . '/widgets/card-info/card-info.php';
      require_once TSIGARAS_T_PATH . '/widgets/line/line.php';

      add_action('elementor/widgets/register', [$this, 'register_widgets']);
    }

    public function register_widgets()
    {
      \Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Tsigaras_Buttons());
      \Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Tsigaras_Slider_Fade());
      \Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Tsigaras_Slider_Main());
      \Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\tsigaras_Single_Video());
      \Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Tsigaras_Card_Info());
      \Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Tsigaras_Tsigaras_Line());
    }
  }
}

if (!function_exists('tsigaras_elementor_init')) {

  function tsigaras_elementor_init()
  {
    Tsigaras_Elementor_Widgets::get_instance();
  }
  add_action('init', 'tsigaras_elementor_init');
}
