<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tsigaras
 */


$logo = get_theme_mod("tsigaras_header_logo", '');

$shortcode = get_theme_mod("tsigaras_footer_shortcode", '');

$phone = get_theme_mod("tsigaras_footer_phone", '');

$email = get_theme_mod("tsigaras_footer_email", '');

$social = !empty(get_theme_mod("global_settings_social_links")) ? get_theme_mod("global_settings_social_links") : '';
$social_array = explode(",", $social);
$social_names = ['twitter', 'linkedin', 'facebook', 'instagram', 'youtube', 'tiktok'];




?>
</main>

<?php if (!is_404()) { ?>
  <footer id="footer" class="tsigaras-footer <?= $white_footer_class ?>">
    <div class="container">
      <div class="tsigaras-footer__wrap">
        <span class="tsigaras-footer__follow-us">follow us</span>
        <a target="_blank" rel="noopener" href="https://www.instagram.com/just1_niko/" class="tsigaras-footer__instagram-name">@Just1_niko</a>


        <?php if (!empty($shortcode)) { ?>
          <div>
            <?= do_shortcode($shortcode); ?>
          </div>
        <?php } ?>

        <div class="tsigaras-global__social footer__social">
          <ul>
            <?php
            foreach ($social_array as $link) {
              foreach ($social_names as $name) {
                if (strpos($link, $name) !== false) {  ?>

                  <li>
                    <a href="<?= $link ?>" title="<?= $name ?>" aria-label="<?= $name ?>" target="_blank" rel="noopener">
                      <?php echo file_get_contents(get_template_directory() . '/assets/image/' . $name . '.svg'); ?>
                    </a>
                  </li>
            <?php }
              }
            } ?>
          </ul>
        </div>
        <div class="tsigaras-header__logo footer__logo desktop">
          <a href="<?php echo esc_url(home_url('/')); ?>">
            <?php if (isset($logo) && !empty($logo)) {
              echo wp_get_attachment_image($logo, 'full');
            } ?>
          </a>
        </div>
        <?php if (!empty($phone)) { ?>
          <p>Phone Number: <a href="tel:<?= $phone ?>"><?= $phone ?></a></p>
        <?php } ?>

        <?php if (!empty($email)) { ?>
          <p>Email: <a href="mailto:<?= $email ?>"><?= $email ?></a></p>
        <?php } ?>
      </div>
    </div>
    <img class="logo-footer_bottom" src="../../../wp-content/themes/tsigaras/assets/image/logo-footer.png" alt="Logo" loading="lazy">
  </footer>
<?php } ?>
</div>
<?php wp_footer(); ?>
</body>

</html>