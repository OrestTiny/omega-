<?php

$news_args = array(
  'post_type' => 'post',
  'posts_per_page' => 3,
  'post__not_in' => array(get_the_ID()),
);

$title = get_theme_mod("tsigaras_blog_single_slider_title", '');
$btn_name = get_theme_mod("tsigaras_blog_single_btn_name", '');
$btn_link = get_theme_mod("tsigaras_blog_single_btn_url", '');

$news_query = new WP_Query($news_args);

?>
<div class="tsigaras-post__slider">
  <div class="container">
    <div class="tsigaras-post__slider-wrap">
      <?php if (!empty($title)) { ?>
        <h2><?= $title ?></h2>
      <?php } ?>

      <?php if (!empty($btn_name)) { ?>
        <a href="<?= $btn_link ?>" class="btn btn-third"><?= $btn_name  ?></a>
      <?php } ?>

      <div class="tsigaras-post__slider-post">


        <?php if ($news_query->have_posts()) { ?>
          <?php while ($news_query->have_posts()) : $news_query->the_post();
            $id = get_the_ID();
          ?>
            <div class="tsigaras-post__slider-item">

              <a class="tsigaras-post__slider-media media-fit" href="<?php echo get_permalink($id); ?>" aria-label="<?php echo get_the_title(); ?>">
                <?php the_post_thumbnail('full'); ?>
              </a>

              <div class="tsigaras-post__slider-item-wrap">
                <div class="tsigaras-post__slider-info p-sm">
                  <?php echo get_the_date(); ?>
                </div>

                <h5 class="p-bg">
                  <a href="<?php echo get_permalink($id); ?>">
                    <?php echo get_the_title(); ?>
                  </a>
                </h5>

                <div class="tsigaras-post__slider-desc">
                  <?php echo get_the_excerpt(); ?>
                </div>

                <a href="<?php echo get_permalink($id); ?>" class="tsigaras-post__slider-btn btn-line" aria-label="<?php echo esc_attr(get_the_title()); ?>">Read More</a>
              </div>
            </div>

        <?php endwhile;
          wp_reset_postdata();
        } ?>

      </div>
    </div>
  </div>
</div>