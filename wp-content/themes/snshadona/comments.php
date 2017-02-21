<div class="sns-comments">
<?php 
if ( post_password_required() ) { ?>
    <p class="no-comments">
    <?php esc_html_e('This post is password protected. Enter the password to view comments.', 'snshadona'); ?>
    </p>
    <?php 
    return; 
}
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
//Custom Fields
$fields =  array(
    'author'=> '<div class="text-field"><div><input name="author" type="text" placeholder="' . esc_html__('Name *', 'snshadona') . '" size="30"' . $aria_req . ' /></div>',
    'email' => '<div><input name="email" type="text" placeholder="' . esc_html__('E-Mail *', 'snshadona') . '" size="30"' . $aria_req . ' /></div>',
    'url'   => '<div><input name="url" type="text" placeholder="' . esc_html__('Your website', 'snshadona') . '" size="30" /></div></div>',
);
//Comment Form Args
$comments_args = array(
    'fields' => $fields,
    'title_reply'=>'<span>'. esc_html__('Leave a comment', 'snshadona') .'</span>',
    'comment_field' => '<div class="your-comment"><div><textarea id="comment" name="comment" placeholder="' . esc_html__('Your comment *', 'snshadona') . '" aria-required="true" cols="58" rows="8" tabindex="4"></textarea></div></div>',
    'label_submit' => esc_html__('Submit comment','snshadona') ,
	'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . esc_html__( 'Your email address will not be published.', 'snshadona' ) . '</span>' . esc_html__( ' Required fields are marked ', 'snshadona' ) . '<span class="required">*</span></p>',
    'comment_notes_after' => ''
    /*'comment_notes_after' => '<p class="form-allowed-tags">' . sprintf( wp_kses(__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'snshadona' ), array(
                                        'abbr' => array(
                                            'title' => array()
                                        ),
                                    )), ' <code>' . allowed_tags() . '</code>' ) . '</p>'*/
);

if ( have_comments() && comments_open() ) : ?>
    <?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
    <h3 id="comments"><span><?php comments_number(esc_html__('Leave a Comment','snshadona'), esc_html__('(1) Comment','snshadona'), '(%)' . esc_html__(' Comments','snshadona') );?></span></h3>
    <ul class="commentlist">
        <?php wp_list_comments('callback=snshadona_comment'); ?>
    </ul>
    <div class="navigation">
        <?php paginate_comments_links(); ?> 
    </div>
    <?php comment_form($comments_args); ?>
<?php 
else :
    if ( comments_open() ) : ?>
    <?php comment_form($comments_args); ?>
    <?php
    endif;
endif; ?>
</div>