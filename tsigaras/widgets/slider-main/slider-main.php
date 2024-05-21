<?php

namespace Elementor;


class Tsigaras_Slider_Main extends Widget_Base
{

  public function get_name()
  {
    return 'tsigaras-slider-main';
  }

  public function get_title()
  {
    return 'Tsigaras Slider Main';
  }

  public function get_icon()
  {
    return 'dashicons dashicons-slides';
  }

  public function get_categories()
  {
    return ['tsigaras'];
  }

  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_enqueue_style('tsigaras-slider-main', TSIGARAS_T_URI . '/widgets/slider-main/slider-main.min.css');
    wp_register_script(
      'tsigaras-slider-main',
      TSIGARAS_T_URI . '/widgets/slider-main/slider-main.min.js',
      array('swiper'),
      '',
      true
    );
  }

  public function get_script_depends()
  {
    return ['tsigaras-slider-main'];
  }

  public function get_style_depends()
  {
    return ['tsigaras-slider-main'];
  }

  protected function _register_controls()
  {

    $this->start_controls_section(
      'section_content',
      [
        'label' => esc_html__('Content', 'tsigaras'),
      ]
    );

    $slides = new Repeater();

    $slides->add_control(
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

    $slides->add_control(
      'title',
      [
        'label' => esc_html__('Title', 'tsigaras'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => esc_html__('Type your title here', 'tsigaras'),
        'placeholder' => esc_html__('Type your title here', 'tsigaras'),
        'label_block' => true,
      ]
    );

    $slides->add_control(
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
      'slides',
      [
        'label'  => esc_html__('Repeater Slides', 'tsigaras'),
        'type'   => \Elementor\Controls_Manager::REPEATER,
        'fields' => $slides->get_controls(),
      ]
    );

    $this->end_controls_section();
  }

  protected function render()
  {

    $settings = $this->get_settings_for_display();

?>
    <div class="tsigaras-slider-main">
      <div class="swiper">
        <div class="swiper-wrapper mb-50">
          <?php foreach ($settings['slides'] as $i) { ?>
            <?php if (!empty($i['media'])) { ?>
              <div class="swiper-slide">
                <div class="tsigaras-slider-main__item">
                  <div class="tsigaras-slider-main__media">
                    <?php echo wp_get_attachment_image($i['media']['id'], 'full'); ?>
                  </div>
                  <h6 class="p-bg"><?= $i['title'] ?></h6>
                  <p class="p-bg"><?= $i['desc'] ?></p>
                </div>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>


<?php
  }
}
