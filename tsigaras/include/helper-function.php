<?php

require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Create custom html structure for comments
 */
if (!function_exists('tsigaras_comment')) {
  function tsigaras_comment($comment, $args, $depth)
  {
    $GLOBALS['comment'] = $comment;

    switch ($comment->comment_type):
      case 'pingback':
      case 'trackback': ?>
        <div class="pinback">
          <span class="pin-title"><?php esc_html_e('Pingback: ', 'tsigaras'); ?></span><?php comment_author_link(); ?>
        <?php edit_comment_link(esc_html__('(Edit)', 'tsigaras'), '<span class="edit-link">', '</span>');
        break;
      default:
        // generate comments
        ?>
          <div <?php comment_class('tsigaras-post__comment'); ?> id="li-comment-<?php comment_ID(); ?>">
            <div class="tsigaras-post__comment-inner" id="comment-<?php comment_ID(); ?>">
              <div class="tsigaras-post__comment-avatar">
                <?php echo get_avatar($comment, '70'); ?>
              </div>
              <div class="tsigaras-post__comment-content">
                <h6 class="tsigaras-post__comment-author"><?php comment_author(); ?></h6>
                <div class="tsigaras-post__comment-date"><?php comment_date(get_option('date_format')); ?></div>
                <?php comment_text(); ?>
                <?php comment_reply_link(
                  array_merge(
                    $args,
                    array(
                      'reply_text' => esc_html__('Reply', 'tsigaras'),
                      'after' => '',
                      'depth' => $depth,
                      'max_depth' => $args['max_depth']
                    )
                  )
                ); ?>
              </div>
            </div>

    <?php
        break;
    endswitch;
  }
}


/**
 * Filter for excerpt more string
 */

if (!function_exists('tsigaras_excerpt_more')) {
  function tsigaras_excerpt_more()
  {
    return ' ...';
  }

  add_filter('excerpt_more', 'tsigaras_excerpt_more');
}



function isLink($data)
{
  $el = $data;

  echo $el['is_external'] ? ' target="_blank" ' : ' target="_self" ';
  echo $el['nofollow'] ? ' rel="noopener" ' : '';
  echo $el['url'] ? ' href="' . esc_url($el['url']) . '" ' : '';
  echo $el['custom_attributes'] ? ' ' . esc_attr($el['custom_attributes']) . ' ' : '';
}
