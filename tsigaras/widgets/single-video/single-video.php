<?php

namespace Elementor;

class tsigaras_Single_Video extends Widget_Base
{

  public function get_name()
  {
    return 'tsigaras-single-video';
  }

  public function get_title()
  {
    return 'tsigaras Single Video';
  }

  public function get_icon()
  {
    return 'dashicons dashicons-slides
';
  }

  public function get_categories()
  {
    return ['tsigaras'];
  }

  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_enqueue_style('tsigaras-single-video', TSIGARAS_T_URI . '/widgets/single-video/single-video.min.css');
    wp_register_script(
      'tsigaras-single-video',
      TSIGARAS_T_URI . '/widgets/single-video/single-video.min.js',
      array('swiper'),
      '',
      true
    );
  }

  public function get_script_depends()
  {
    return ['tsigaras-single-video'];
  }

  public function get_style_depends()
  {
    return ['tsigaras-single-video'];
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
      'source',
      [
        'label' => esc_html__('Source', 'tsigaras'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'hosted',
        'options' => [
          'hosted' => esc_html__('Self Hosted', 'tsigaras'),
          'youtube' => esc_html__('YouTube', 'tsigaras'),
          'vimeo'  => esc_html__('Vimeo', 'tsigaras')
        ],
        'onChange' => 'changeFields'
      ]
    );

    $this->add_control(
      'video',
      [
        'label' => esc_html__('Choose Video', 'tsigaras'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'media_types' => ['video'],
        'default' => [
          'url' => '',
        ],
        'condition' => [
          'source' => 'hosted'
        ]
      ]
    );

    $this->add_control(
      'video_url',
      [
        'label' => esc_html__('Video URL', 'tsigaras'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'input_type' => 'url',
        'placeholder' => esc_html__('Enter video URL (e.g., https://www.youtube.com/watch?v=xyz)', 'tsigaras'),
        'condition' => [
          'source' => ['youtube', 'vimeo']
        ],
        'label_block' => true,
      ]
    );

    $this->end_controls_section();
  }

  protected function render()
  {

    $settings = $this->get_settings_for_display();


?>


    <div class="tsigaras-single-video">



      <?php if ($settings['source'] == 'hosted' && !empty($settings['video']['url'])) { ?>
        <a class="tsigaras-single-video__media video-icon" href="<?php echo esc_url($settings['video']['url']) ?>" data-fancybox="video" data-autoplay="true">

          <?php if (!empty($settings['video']['url']) && empty($settings['image']['url'])) { ?>
            <video playsinline loop>
              <source src="<?php echo esc_url($settings['video']['url']) ?>" type="video/mp4">
            </video>
          <?php } ?>
        </a>
      <?php } ?>

      <?php if ($settings['source'] == 'youtube' || $settings['source'] == 'vimeo' && !empty($settings['video']['url'])) { ?>
        <a class="tsigaras-single-video__media" href="<?php echo esc_url($settings['video_url']) ?>" data-fancybox="video" data-autoplay="true">

          <?php if (!empty($settings['video']['url']) && empty($settings['image']['url'])) { ?>
            <iframe src="<?php echo esc_url($settings['video_url']) ?>?autoplay=0&controls=0&showinfo=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
          <?php } ?>

          <?php if (!empty($settings['image']['url'])) { ?>
            <?php echo wp_get_attachment_image($settings['image']['id'], 'full', array('loading' => 'lazy',)); ?>
          <?php } ?>


          <div class="tsigaras-single-video__btn">
            <div class="tsigaras-single-video__btn-wrap">
              <svg width="28" height="31" viewBox="0 0 28 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M27.2818 14.6304C27.9569 15.0136 27.9569 15.9864 27.2818 16.3696L2.08696 30.6734C1.42032 31.0519 0.593252 30.5704 0.593252 29.8038V1.19618C0.593252 0.429595 1.42032 -0.0519187 2.08696 0.326551L27.2818 14.6304Z" fill="rgba(248, 181, 47, 1)" />
              </svg>
            </div>

            <p>Watch Video</p>
          </div>

        </a>
      <?php } ?>


    </div>




<?php
  }
}
