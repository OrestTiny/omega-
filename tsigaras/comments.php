<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Tsigaras
 */


if (post_password_required()) {
  return;
} ?>

<?php // Comment list
$comment_list = get_comments_number(get_the_id());
if ($comment_list > 0) : ?>
  <h3 class="tsigaras-post__comments-title"><?php printf(
                                              _nx('1 comment', '<span class="count">%1$s Comments</span>', get_comments_number(), 'comments', 'tsigaras'),
                                              number_format_i18n(get_comments_number())
                                            ); ?></h3>
  <?php wp_list_comments(array('callback' => 'tsigaras_comment', 'style' => 'div')); ?>


<?php endif; ?>

<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
  <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
    <h1 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'tsigaras'); ?></h1>
    <div class="nav-previous"><?php previous_comments_link(esc_html__('&larr; Older comments', 'tsigaras')); ?></div>
    <div class="nav-next"><?php next_comments_link(esc_html__('Newer comments &rarr;', 'tsigaras')); ?></div>
  </nav>
<?php endif; ?>


<?php

$fields = array(
  'author' => '<input required id="name" type="text" name="author" placeholder="' . esc_attr__('Full name*', 'tsigaras') . '" size="30" tabindex="1" />',
  'email'  => '<input required id="email" type="email" name="email" placeholder="' . esc_attr__('Email*', 'tsigaras') . '" size="30" tabindex="2" />',
);

$comments_args = array(
  'id_form'              => 'contactform',
  'fields'               => $fields,
  'comment_field'        => '<div class="form-group"><textarea required id="comment" name="comment" placeholder="' . esc_attr__('Comment*', 'tsigaras') . '" rows="8" cols="60" tabindex="3"></textarea>',
  'must_log_in'          => '',
  'logged_in_as'         => '',
  'comment_notes_before' => '',
  'comment_notes_after'  => '',
  'title_reply'          => sprintf(esc_html__('Leave a comment', 'tsigaras')),
  'title_reply_to'       => esc_html__('Leave a reply to %s', 'tsigaras'),
  'title_reply_before'   => '<h2 id="reply-title" class="comment-reply-title">',
  'title_reply_after'    => '</h2>',
  'cancel_reply_link'    => esc_html__('Cancel', 'tsigaras'),
  'label_submit'         => esc_html__('Submit', 'tsigaras'),
  'submit_field'         => '</div><div class="input-wrapper clearfix">%1$s %2$s<span id="message"></span></div>',
);
?>
<div class="tsigaras-post__comments-form">
  <?php comment_form($comments_args); ?>
</div>