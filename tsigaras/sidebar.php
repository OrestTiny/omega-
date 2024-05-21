<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tsigaras
 */

$img = get_theme_mod("tsigaras_blog_single_sidebar_img", '');
$title = get_theme_mod("tsigaras_blog_single_sidebar_title", '');
$desc = get_theme_mod("tsigaras_blog_single_sidebar_desc", '');
$btn_name = get_theme_mod("tsigaras_blog_single_sidebar_name", '');
$btn_link = get_theme_mod("tsigaras_blog_single_sidebar_link", '');

?>

<div class="tsigaras-post__sidebar">
  <div class="tsigaras-post__sidebar-wrap">
    <div class="tsigaras-post__sidebar-subscribe">
      <h3>Subscribe to be in touch with latest news</h3>
      <form>
        <input type="text" placeholder="Enter your email">
        <button type="submit">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
            <path d="M4.5 12H20.5M20.5 12L14.5 18M20.5 12L14.5 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </form>
    </div>


    <?php if (!empty($title)) { ?>
      <div class="tsigaras-post__sidebar-contact">
        <div class="tsigaras-post__sidebar-contact-media">
          <?php echo wp_get_attachment_image($img, 'full'); ?>
        </div>
        <h3><?= $title ?></h3>
        <p><?= $desc ?></p>
        <a href="<?= $btn_link ?>" class="btn btn-pr"><?= $btn_name ?></a>
      </div>
    <?php } ?>
  </div>
</div>