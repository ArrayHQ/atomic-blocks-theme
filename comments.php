<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Atomic Blocks
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
?>

<?php
	if ( comments_open() || '0' != get_comments_number() ) {

	if ( post_password_required() ) {
		return;
	}

	if ( comments_open() ) {
		$comment_class = 'comments-open';
	} else {
		$comment_class = 'comments-closed';
	}
?>

<div id="comments" class="comments-area <?php echo esc_attr( $comment_class ); ?>">
	<div class="comments-wrap">

		<?php if ( have_comments() ) : ?>
			<h3 class="comment-reply-title comments-title">
				<span>
				<?php
					$comments_number = get_comments_number();
					if ( '1' === $comments_number ) {
						/* translators: %s: post title */
						printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'atomic-blocks' ), get_the_title() );
					} else {
						printf(
							/* translators: 1: number of comments, 2: post title */
							_nx(
								'%1$s Reply to &ldquo;%2$s&rdquo;',
								'%1$s Replies to &ldquo;%2$s&rdquo;',
								$comments_number,
								'comments title',
								'atomic-blocks'
							),
							number_format_i18n( $comments_number ),
							get_the_title()
						);
					}
				?>
				</span>
			</h3>

			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 50,
						'callback'    => 'atomic_blocks_comment'
					) );
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-above" class="comment-navigation">
				<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'atomic-blocks' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'atomic-blocks' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'atomic-blocks' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
			<?php endif; // check for comment navigation ?>

		<?php endif; // have_comments() ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><span><?php esc_html_e( 'Comments are closed.', 'atomic-blocks' ); ?></span></p>
		<?php endif; ?>

		<?php comment_form(); ?>
	</div><!-- .comments-wrap -->
</div><!-- #comments -->

<?php } // If comments are open and we have comments ?>
