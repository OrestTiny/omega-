<?php

/**
 * Index Page
 *
 * @package tsigaras
 * @since 1.0
 *
 */

get_header();

$search = get_query_var('s');
$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;

$args = array(
  'post_type' => 'post',
  'paged' => $paged,
);

if (is_search()) {
  $args['s'] = $search;
}

$title = esc_html__('Blog', 'tsigaras');

if (is_category() || is_tag()) {
  $term = get_queried_object();

  $term_name = $term->taxonomy;

  $args['tax_query'] = array(
    array(
      'taxonomy' => $term_name,
      'field' => 'term_id',
      'terms' => $term->term_id,
    ),
  );

  $title = is_category() ? esc_html__('Category: ', 'tsigaras') . $term->name : $title;
  $title = is_tag() ? esc_html__('Tag: ', 'tsigaras') . $term->name : $title;
}

if (is_archive()) {
  $title = get_the_archive_title();
  $args['year'] = get_query_var('year');
  $args['monthnum'] = get_query_var('monthnum');
  $args['day'] = get_query_var('day');
  $args['w'] = get_query_var('w');
}

$posts = new WP_Query($args); ?>

<div class="tsigaras-blog">

  <?php if (!is_search()) {
    $feature_post_id = get_theme_mod("tsigaras_blog_feature_post", '');
    $categories = get_the_category($feature_post_id);
    $category_names = array();
    foreach ($categories as $category) {
      $category_names[] = $category->name;
    }
    $category_list = implode(', ', $category_names);
    $post_date = get_the_date('M j, Y', $feature_post_id);

  ?>
    <div class="tsigaras-blog__feature">
      <div class="container">
        <div class="tsigaras-blog__feature-wrap">
          <?php if (get_post_thumbnail_id($feature_post_id)) { ?>
            <a class="tsigaras-blog__feature-media media-fit" data-an-fadeup="400" href="<?php echo get_permalink($feature_post_id); ?>">
              <?php echo get_the_post_thumbnail($feature_post_id, 'full'); ?>
            </a>

          <?php } ?>

          <div class="tsigaras-blog__feature-content">
            <div class="tsigaras-blog__feature-cat p-sm mb-20" data-an-fadeup="400">
              <?php echo $category_list; ?> • <?php echo $post_date; ?>
            </div>

            <h1 data-an-fadeup="400">
              <a href="<?php echo get_permalink($feature_post_id); ?>">
                <?= get_the_title($feature_post_id) ?>
              </a>
            </h1>

            <div class="tsigaras-blog__feature-excerpt" data-an-fadeup="400">
              <?= get_the_excerpt($feature_post_id) ?>
            </div>

            <a href="<?php echo get_permalink($feature_post_id); ?>" class="btn btn-pr" data-an-fadeup="400">
              <?= esc_html__('Read More', 'tsigaras') ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="container">
    <div class="tsigaras-blog__wrap">

      <div class="tsigaras-blog__head">
        <?php
        $title = get_theme_mod("tsigaras_blog_banner_title", $title);
        $banner_subtitle = get_theme_mod("tsigaras_blog_banner_subtitle", '');
        ?>

        <?php if (!empty($title) && !empty($banner_subtitle)) { ?>
          <div class="tsigaras-blog__head-headline">
            <h2 data-an-fadeUp="400"><?= $title ?></h2>
            <p data-an-fadeUp="400"><?= $banner_subtitle ?></p>
          </div>
        <?php } ?>

        <ul class="tsigaras-blog__head-category" data-an-fadeUp="400">
          <?php
          $archive_link = get_post_type_archive_link('post');
          $blog_archive =  !is_category()  ? 'class="active"' : '';

          echo '<li><a ' . $blog_archive . ' href="' .  $archive_link . '">View All</a></li>';

          $categories = get_categories();
          $current_category_id = get_queried_object_id();

          foreach ($categories as $category) {
            $category_link = get_category_link($category->term_id);
            $category_name = $category->name;

            if (is_category($category->term_id)) {
              $class = 'active';
            } else {
              $class = '';
            }

            echo '<li><a class="' . $class . '" href="' . $category_link . '" >' . $category_name . '</a></li>';
          }

          ?>
        </ul>
      </div>

      <div class="tsigaras-blog__posts">
        <?php
        $posts = new WP_Query($args);
        if ($posts->have_posts()) {
          while ($posts->have_posts()) :
            $posts->the_post();

            $post_id = get_the_ID();
            $format = get_post_format($post_id) ? get_post_format($post_id) : 'image';
        ?>

            <div data-an-fadeup="400" <?php post_class("tsigaras-blog__item " . esc_attr($format)); ?>>
              <?php if (has_post_thumbnail()) { ?>

                <a class="tsigaras-blog__item-media media-fit" href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('full'); ?>
                </a>

              <?php } ?>

              <div class="tsigaras-blog__item-content">
                <a href="<?php the_permalink(); ?>" class="tsigaras-blog__item-date p-sm">
                  <?php the_time(get_option('date_format')); ?>
                </a>

                <?php if (!empty(get_the_title())) { ?>
                  <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <?php } ?>


                <div class="tsigaras-blog__item-excerpt">
                  <?php the_excerpt(); ?>
                </div>

                <a href="<?php the_permalink(); ?>" class="btn-line">Read More</a>
              </div>
            </div>

          <?php endwhile;
          wp_reset_postdata();
        } else { ?>
          <h4><?php esc_html_e('Sorry, no posts matched your criteria.', 'tsigaras'); ?></h4>
        <?php } ?>

      </div>
      <?php if ($posts->max_num_pages > 1) { ?>
        <div class="tsigaras-blog__pagination" data-an-fadeup="400">
          <?php echo paginate_links(
            array(
              'total' => $posts->max_num_pages,
              'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
                              <path d="M7 1L1 7L7 13" stroke="#FF4200" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>',
              'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M9 6L15 12L9 18" stroke="#FF4200" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>'
            )
          ); ?>
        </div>
      <?php } ?>
    </div>
  </div>

  <?php
  $cta_bg = get_theme_mod("tsigaras_blog_cta_bg");
  $cta_bg = !empty($cta_bg) ? 'style="background-image:url(' . esc_url(wp_get_attachment_image_url($cta_bg, 'full')) . ');"' : '';

  $subtitle = get_theme_mod("blog_cta_settings_subtitle");
  $title = get_theme_mod("blog_cta_settings_title");
  $desc = get_theme_mod("blog_cta_settings_desc");

  $btn_name = get_theme_mod("blog_cta_settings_btn");
  $btn_link = get_theme_mod("blog_cta_settings_btn_link");
  ?>

  <?php if (!empty($title)) { ?>
    <div class="tsigaras-blog__cta" <?= $cta_bg ?>>
      <div class="container">
        <div class="tsigaras-blog__cta-wrap">
          <?php if (!empty($subtitle)) { ?>
            <p class="p-sm mb-20" data-an-fadeup="400"><?= $subtitle ?></p>
          <?php } ?>

          <h2 data-an-fadeup="400"><?= $title ?></h2>

          <?php if (!empty($desc)) { ?>
            <p class="mb-50" data-an-fadeup="400"><?= $desc ?></p>
          <?php } ?>

          <?php if (!empty($btn_name)) { ?>
            <a href="<?= $btn_link ?>" class="btn btn-fourth" data-an-fadeup="400"><?= $btn_name ?></a>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php get_template_part('template-parts/newsletter'); ?>

</div>

<?php

get_footer();
