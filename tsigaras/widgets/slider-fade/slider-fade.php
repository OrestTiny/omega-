<?php

namespace Elementor;

class Tsigaras_Slider_Fade extends Widget_Base
{

  public function get_name()
  {
    return 'tsigaras-slider-fade';
  }

  public function get_title()
  {
    return 'Tsigaras Fade Slider';
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
    wp_register_style('tsigaras-slider-fade', TSIGARAS_T_URI . '/widgets/slider-fade/slider-fade.min.css');
    wp_register_script(
      'tsigaras-slider-fade',
      TSIGARAS_T_URI . '/widgets/slider-fade/slider-fade.min.js',
      array('swiper'),
      '',
      true
    );
  }

  public function get_script_depends()
  {
    return ['tsigaras-slider-fade'];
  }

  public function get_style_depends()
  {
    return ['tsigaras-slider-fade'];
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
      'delay',
      [
        'label' => esc_html__('Slider Delay', 'tsigaras'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 10000,
        'default' => 3500,
      ]
    );

    $this->add_control(
      'speed',
      [
        'label' => esc_html__('Slider Speed', 'tsigaras'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 0,
        'max' => 10000,
        'default' => 1500,
      ]
    );

    $this->add_responsive_control(
      'width',
      [
        'label' => esc_html__('Width Height', 'textdomain'),
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
          '{{WRAPPER}} .tsigaras-slider-fade h1' => 'width: {{SIZE}}{{UNIT}};',
        ],
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

    $delay = !empty($settings['delay']) ? ' data-delay="' . $settings['delay'] . '"' : '';
    $speed = !empty($settings['speed']) ? ' data-speed="' . $settings['speed'] . '"' : '';

?>
    <div class="tsigaras-slider-fade" <?php echo $delay,  $speed; ?>>

      <div class="swiper">
        <div class="swiper-wrapper">
          <?php foreach ($settings['slides'] as $i) { ?>
            <div class="swiper-slide">
              <div class="tsigaras-slider-fade__item">

                <?php echo wp_get_attachment_image($i['media']['id'], 'full'); ?>

              </div>
            </div>
          <?php } ?>
        </div>


        <div class="tsigaras-slider-fade__main">
          <div class="container">
            <div class="tsigaras-slider-fade__main-wrap">
              <div class="tsigaras-slider-fade__main-heading">
                <h1 class="hero mb-40">
                  <?= $settings['title'] ?>
                </h1>
              </div>

              <p class="mb-40 h-line"><?= $settings['desc']  ?></p>
              <a class="btn btn-pr" <?php isLink($settings['btn_url']) ?>><?php echo esc_html__($settings['btn_name'], 'tsigaras') ?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
  }
}
