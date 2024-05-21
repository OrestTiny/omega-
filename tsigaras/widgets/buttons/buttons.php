<?php

namespace Elementor;

class Tsigaras_Buttons extends Widget_Base
{

  public function get_name()
  {
    return 'buttons';
  }

  public function get_title()
  {
    return 'Tsigaras Button';
  }

  public function get_icon()
  {
    return 'dashicons dashicons-button';
  }

  public function get_categories()
  {
    return ['tsigaras'];
  }

  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_style('tsigaras-buttons', TSIGARAS_T_URI . '/widgets/buttons/buttons.css');
  }

  // public function get_style_depends()
  // {
  //   return ['tsigaras-buttons'];
  // }

  protected function _register_controls()
  {

    $this->start_controls_section(
      'section_content',
      [
        'label' => esc_html__('Content', 'tsigaras'),
      ]
    );

    $this->add_control(
      'btn_type',
      [
        'label' => esc_html__('Button Type', 'tsigaras'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'btn btn-pr',
        'options' => [
          'btn btn-pr'  => esc_html__('Primary', 'tsigaras'),
          'btn btn-sec' => esc_html__('Secondary', 'tsigaras'),
        ],
      ]
    );

    $this->add_control(
      'btn_name',
      [
        'label'       => esc_html__('Button Text', 'tsigaras'),
        'type'        => Controls_Manager::TEXT,
        'default'     => esc_html__('Learn More', 'tsigaras'),
        'label_block' => true,
      ]
    );

    $this->add_control(
      'btn_url',
      [
        'label'       => esc_html__('Button URL', 'tsigaras'),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'tsigaras'),
        'default'     => [
          'url' => '',
        ]
      ]
    );

    $this->end_controls_section();
  }

  protected function render()
  {

    $settings = $this->get_settings_for_display(); ?>

    <a class="<?php echo $settings['btn_type'] ?>" <?php isLink($settings['btn_url']) ?>><?php echo esc_html__($settings['btn_name'], 'tsigaras') ?></a>
<?php
  }
}
