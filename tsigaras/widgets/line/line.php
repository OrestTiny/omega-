<?php

namespace Elementor;

class Tsigaras_Tsigaras_Line extends Widget_Base
{

  public function get_name()
  {
    return 'tsigaras-line';
  }

  public function get_title()
  {
    return 'Tsigaras Line';
  }

  public function get_icon()
  {
    return 'dashicons dashicons-minus';
  }

  public function get_categories()
  {
    return ['tsigaras'];
  }

  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_style('tsigaras-line', TSIGARAS_T_URI . '/widgets/line/line.min.css');
  }

  public function get_style_depends()
  {
    return ['tsigaras-line'];
  }

  protected function _register_controls()
  {

    $this->start_controls_section(
      'section_content',
      [
        'label' => esc_html__('Content', 'tsigaras'),
      ]
    );

    $this->add_responsive_control(
      'width',
      [
        'label' => esc_html__('Width', 'textdomain'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 1000,
            'step' => 5,
          ],
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 73,
        ],
        'selectors' => [
          '{{WRAPPER}} .tsigaras-line' => 'width: {{SIZE}}{{UNIT}};',
        ],
      ]
    );
    $this->end_controls_section();
  }

  protected function render()
  {

    $settings = $this->get_settings_for_display(); ?>

    <div class="tsigaras-line"></div>
<?php
  }
}
