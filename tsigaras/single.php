<?php

/**
 * Single post
 */

get_header();

while (have_posts()) :
  the_post();

  $post_id = get_the_ID(); ?>


  <div class="tsigaras-post__banner">
    <div class="container">
      <div class="tsigaras-post__banner-wrap">

        <div class="tsigaras-post__banner-img">
          <?php
          if (has_post_thumbnail()) {
            the_post_thumbnail('full');
          } ?>
        </div>

        <div class="tsigaras-post__banner-main">
          <div class="tsigaras-post__banner-cat mb-25">
            <?php
            if (has_category()) {
              $categories = get_the_category();

              foreach ($categories as $category) {
                $category_link = get_category_link($category->term_id);
                $category_name = $category->name; ?>

                <a href="<?= $category_link  ?>">
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="8" cy="8" r="8" fill="#FF4200" fill-opacity="0.2" />
                    <circle cx="8" cy="8" r="4" fill="#FF4200" />
                  </svg>

                  <?= $category_name  ?>
                </a>
            <?php
              }
            } ?>
          </div>

          <h1><?php the_title(); ?></h1>

          <div class="tsigaras-post__banner-exce">
            <?php echo get_the_excerpt(); ?>
          </div>

          <div class="tsigaras-post__banner-auth mb-50">
            <span><?php echo get_the_date('M j, Y'); ?></span>
            •
            <span>by <?php echo get_the_author(); ?></span>
          </div>

          <div class="tsigaras-post__banner-sharer">

            <?php

            $copy = file_get_contents(get_template_directory() . '/assets/image/copy-white.svg');
            $facebook = file_get_contents(get_template_directory() . '/assets/image/facebook-white.svg');
            $linkedin = file_get_contents(get_template_directory() . '/assets/image/linkedin-white.svg');
            $twitter = file_get_contents(get_template_directory() . '/assets/image/twitter-white.svg');

            $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink();
            $linkedin_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . esc_url(get_permalink());
            $twitter_url = 'https://twitter.com/share?' . esc_url(get_permalink()) . '&amp;text=' . get_the_title();

            ?>

            <a href="<?php echo get_the_permalink() ?>" id="tsigaras-copy-post"><?php echo $copy ?></a>
            <a href="<?php echo $linkedin_url ?>" target="_blank" rel="noopener"><?php echo $linkedin ?></a>
            <a href="<?php echo $facebook_url ?>" target="_blank" rel="noopener"><?php echo $facebook ?></a>
            <a href="<?php echo $twitter_url ?>" target="_blank" rel="noopener"><?php echo $twitter ?></a>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="tsigaras-post__wrap">
      <div class="tsigaras-post__content">
        <?php the_content();  ?>
      </div>

      <?php get_sidebar(); ?>
    </div>
  </div>



  <?php get_template_part('template-parts/recent-posts'); ?>


<?php endwhile;

wp_reset_postdata();

get_footer();
