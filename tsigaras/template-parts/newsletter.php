<?php if (!isset($_COOKIE['notification'])) {
  $text = get_theme_mod("footer_newsletter_text");
  $shortcode = get_theme_mod("footer_newsletter_shortcode");
  $days = get_theme_mod("footer_newsletter_days");

?>
  <div class="tsigaras-newsletter" data-days="<?= !empty($days) ? $days : 30; ?>">

    <div class="tsigaras-newsletter-wrap">

      <p class="tsigaras-newsletter-des p-bg">
        <?= $text ?>
      </p>

      <div class="tsigaras-newsletter-form">
        <form>
          <input type="text" placeholder="Enter your email">
          <button type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
              <path d="M4.5 12H20.5M20.5 12L14.5 18M20.5 12L14.5 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </form>
      </div>

      <button class="tsigaras-newsletter-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
          <path d="M12.75 5.25L5.25 12.75M5.25 5.25L12.75 12.75" stroke="#5E5969" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </div>

  </div>
<?php } ?>