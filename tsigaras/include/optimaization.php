<?php

// Disable REST API link tag
remove_action('wp_head', 'rest_output_link_wp_head', 10);

// Disable SVG
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
remove_filter('render_block', 'wp_render_layout_support_flag', 10, 2);

// HTML Compression
class TSIGARAS_HTML_Compression
{
  protected $tsigaras_compress_css = true;
  protected $tsigaras_compress_js = true;
  protected $tsigaras_info_comment = true;
  protected $tsigaras_remove_comments = true;
  protected $html;

  public function __construct($html)
  {
    if (!empty($html)) {
      $this->tsigaras_parseHTML($html);
    }
  }

  public function __toString()
  {
    return $this->html;
  }

  protected function tsigaras_bottomComment($raw, $compressed)
  {
    $raw = strlen($raw);
    $compressed = strlen($compressed);
    $savings = ($raw - $compressed) / $raw * 100;
    $savings = round($savings, 2);
    return '<!--HTML compressed, size saved ' . $savings . '%. From ' . $raw . ' bytes, now ' . $compressed . ' bytes-->';
  }

  protected function tsigaras_minifyHTML($html)
  {
    $pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
    preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
    $overriding = false;
    $raw_tag = false;
    $html = '';
    foreach ($matches as $token) {
      $tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
      $content = $token[0];
      if (is_null($tag)) {
        if (!empty($token['script'])) {
          $strip = $this->tsigaras_compress_js;
        } else if (!empty($token['style'])) {
          $strip = $this->tsigaras_compress_css;
        } else if ($content == '<!--wp-html-compression no compression-->') {
          $overriding = !$overriding;
          continue;
        } else if ($this->tsigaras_remove_comments) {
          if (!$overriding && $raw_tag != 'textarea') {
            $content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
          }
        }
      } else {
        if ($tag == 'pre' || $tag == 'textarea') {
          $raw_tag = $tag;
        } else if ($tag == '/pre' || $tag == '/textarea') {
          $raw_tag = false;
        } else {
          if ($raw_tag || $overriding) {
            $strip = false;
          } else {
            $strip = true;
            $content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
            $content = str_replace(' />', '/>', $content);
          }
        }
      }
      if ($strip) {
        $content = $this->tsigaras_removeWhiteSpace($content);
      }
      $html .= $content;
    }
    return $html;
  }

  public function tsigaras_parseHTML($html)
  {
    $this->html = $this->tsigaras_minifyHTML($html);
    if ($this->tsigaras_info_comment) {
      $this->html .= "\n" . $this->tsigaras_bottomComment($html, $this->html);
    }
  }

  protected function tsigaras_removeWhiteSpace($str)
  {
    $str = str_replace("\t", ' ', $str);
    $str = str_replace("\n", '', $str);
    $str = str_replace("\r", '', $str);
    while (stristr($str, '  ')) {
      $str = str_replace('  ', ' ', $str);
    }
    return $str;
  }
}

function tsigaras_wp_html_compression_finish($html)
{
  return new TSIGARAS_HTML_Compression($html);
}

function tsigaras_wp_html_compression_start()
{
  ob_start('tsigaras_wp_html_compression_finish');
}

add_action('get_header', 'tsigaras_wp_html_compression_start');


//Disable gutenberg style in Front
function tsigaras_deregister_styles()
{
  wp_dequeue_style('classic-theme-styles');

  if (!is_single() || !is_singular('post')) {
    wp_dequeue_style('wp-block-library-theme'); // Wordpress core
    wp_dequeue_style('wp-block-library'); // Wordpress core
    wp_dequeue_style('wc-blocks-style');
  }

  if (get_post_type() == 'page') {
    wp_dequeue_script('jquery-blockui');
    wp_dequeue_script('jquery-placeholder');
    wp_dequeue_script('jquery-cookie');
  }
}
add_action('wp_enqueue_scripts', 'tsigaras_deregister_styles', 100);



if (!function_exists('tsigaras_disable_emojis')) {
  function tsigaras_disable_emojis()
  {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  }
  add_action('init', 'tsigaras_disable_emojis');
}
