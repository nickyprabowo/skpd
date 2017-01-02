<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<h2 class="comments-title">
			KOMENTAR
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ul class="comment-list">
			<?php
			
				wp_list_comments( array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 48,
				) );
			
			?>
		</ul><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;' ) ); ?></div>
			</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php _e( 'Comments are closed.' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel-comment">
				<?php
				$commenter = wp_get_current_commenter();
				$req = get_option( 'require_name_email' );
				$aria_req = ( $req ? " aria-required='true'" : '' );
				$required_text = "email"; 

				$args = array(
						'id_form'           => 'commentform',
						'class_form'        => 'ui reply form',
						'id_submit'         => 'submit',
						'class_submit'      => 'ui blue submit button',
						'name_submit'       => 'submit',
						'title_reply'       => __( 'Leave a Reply' ),
						'title_reply_to'    => __( 'Leave a Reply to %s' ),
						'cancel_reply_link' => __( 'Cancel Reply' ),
						'label_submit'      => __( 'Post Comment' ),

						'fields'	=>	apply_filters('comment_form_default_fields', array(
								'author' => '<div class="required field comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="50"' . $aria_req . ' /></div>',
							    'email'  => '<div class="required field comment-form-email"><label for="email">' . __( 'Email' ) . '</label> <input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>'
									)
								),

						'comment_field' =>  '<div class="field"><label for="comment">' . _x( 'Comment', 'noun' ) .
								'</label><textarea id="comment" name="comment" cols="45" rows="5" aria-required="true">' .
								'</textarea></p><br/>',

						'must_log_in' => '<p class="must-log-in">' .
								sprintf(
										__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
										wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
								) . '</p>',

						'logged_in_as' => '<p class="logged-in-as">' .
								sprintf(
										__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
										admin_url( 'profile.php' ),
										$user_identity,
										wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
								) . '</p>',

						'comment_notes_before' => '<p class="comment-notes">' .
								__( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
								'</p>',

						'comment_notes_after' => ''
				);
				
				ob_start();
				comment_form($args);
				echo str_replace('class="comment-form"','class="ui form"',ob_get_clean());

				?>
			</div>
		</div>
	</div>

</div><!-- #comments -->