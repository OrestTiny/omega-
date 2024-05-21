<?php

namespace Elementor;

class Tsigaras_Card_Info extends Widget_Base
{

  public function get_name()
  {
    return 'card-info';
  }

  public function get_title()
  {
    return 'Tsigaras Card Info';
  }

  public function get_icon()
  {
    return 'dashicons dashicons-index-card';
  }

  public function get_categories()
  {
    return ['tsigaras'];
  }

  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_style('tsigaras-card-info', TSIGARAS_T_URI . '/widgets/card-info/card-info.min.css');
  }

  public function get_style_depends()
  {
    return ['tsigaras-card-info'];
  }

  protected function _register_controls()
  {

    $this->start_controls_section(
      'section_content',
      [
        'label' => esc_html__('Content', 'tsigaras'),
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => esc_html__('Title', 'tsigaras'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => esc_html__('Type your title here', 'tsigaras'),
        'placeholder' => esc_html__('Type your title here', 'tsigaras'),
        'label_block' => true,
      ]
    );

    $this->add_control(
      'desc',
      [
        'label' => esc_html__('Description', 'tsigaras'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => esc_html__('Type your title here', 'tsigaras'),
        'placeholder' => esc_html__('Type your title here', 'tsigaras'),
        'label_block' => true,
      ]
    );

    $this->add_control(
      'media',
      [
        'label'       => esc_html__('Media', 'tsigaras'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'placeholder' => esc_html__('Select image', 'tsigaras'),
        'show_label' => false,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
      ]
    );




    $this->end_controls_section();
  }

  protected function render()
  {

    $settings = $this->get_settings_for_display(); ?>

    <div class="tsigaras-card-info">
      <?php echo wp_get_attachment_image($settings['media']['id'], 'full'); ?>

      <div class="tsigaras-card-info__main">
        <div class="tsigaras-card-info__main-wrap">
          <h5><?= $settings['title'] ?></h5>
          <p><?= $settings['desc']  ?></p>
        </div>
      </div>
    </div>

<?php
  }
}
