<?php

/**
 * 404 Page
 */

get_header();

$background = get_theme_mod('tsigaras_error_bg');
$description = get_theme_mod('tsigaras_error_description', 'Sorry, but the page you are looking for does not exist or removed. Please use button given below to find what you are looking or use the main menu.');

$style = isset($background) && !empty($background) ? 'style="background-image:url(' . esc_url($background) . ');"' : ''; ?>

<div class="tsigaras-error__wrap" <?php echo $style; ?>>

  <div class="tsigaras-error__title">
    <?php esc_html_e('404', 'tsigaras'); ?>
  </div>
  <?php if (!empty($description)) { ?>
    <div class="tsigaras-error__description">
      <?php echo esc_html($description); ?>
    </div>
  <?php } ?>
  <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
    <?php esc_html_e('Go home', 'tsigaras'); ?>
  </a>

</div>

<?php get_footer();
