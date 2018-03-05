<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Atomic Blocks
 */
?>

	</div><!-- #content -->
</div><!-- #page .container -->

<?php
	$blog_section = get_theme_mod( 'atomic_blocks_portfolio_blog_section', 'enabled' );

	if ( $blog_section == 'enabled' ) {

	wp_reset_query();

	if ( is_page_template( 'templates/template-portfolio-block.php' ) ||
 		is_page_template( 'templates/template-portfolio-carousel.php' ) ||
		is_page_template( 'templates/template-portfolio-grid.php' ) ||
		is_page_template( 'templates/template-portfolio-masonry.php' ) ) { ?>
<div class="blog-section">
	<div class="container">
		<?php
			$blog_section_title = get_theme_mod( 'atomic_blocks_portfolio_blog_text', esc_html__( 'Latest from the blog', 'atomic-blocks' ) );

			if ( $blog_section_title ) {
				echo '<h3>' . $blog_section_title . '</h3>';

				$post_count = wp_count_posts()->publish;

				if ( $post_count > 3 ) {
					echo '<a class="view-all-posts" href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '"><i class="fa fa-file-text-o"> </i>' . esc_html__( 'View All', 'atomic-blocks' ) . '</a>';
				}
			}
		?>

		<div class="blog-section-posts">
		<?php
			$blog_list_args = array(
                'posts_per_page' => 3
            );
            $blog_list_posts = new WP_Query( $blog_list_args );
	        ?>

	        <?php
	        if ( $blog_list_posts->have_posts() ) :
	        while( $blog_list_posts->have_posts() ) : $blog_list_posts->the_post() ?>
	            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	                <?php if ( has_post_thumbnail() ) { ?>
	                    <div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'atomic-portfolio' ); ?></a></div>
	                <?php } ?>

	                <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

					<?php atomic_blocks_post_byline(); ?>
	            </article><!-- #post-## -->
	        <?php
				endwhile;
				endif;
				wp_reset_postdata();
			?>
		</div><!-- .blog-section-posts -->
    </div><!-- .container -->
</div><!-- .blog-section -->
<?php } } ?>

<?php
	// Related Posts
	if ( class_exists( 'Jetpack_RelatedPosts' ) && is_singular( 'post' ) ) {
		echo '<div class="related-post-wrap">';
			echo '<div class="container">';
				echo do_shortcode( '[jetpack-related-posts]' );
			echo '</div>';
		echo '</div>';
	}
?>

<footer id="colophon" class="site-footer">
	<div class="container">
		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
			<div class="footer-widgets">
				<?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php } ?>

				<?php if ( is_active_sidebar( 'footer-2' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				<?php } ?>

				<?php if ( is_active_sidebar( 'footer-3' ) ) { ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
				<?php } ?>
			</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<div class="footer-tagline">
				<div class="site-info">
					<?php echo atomic_blocks_filter_footer_text(); ?>
				</div>
			</div><!-- .footer-tagline -->

			<?php if ( has_nav_menu( 'social' ) ) { ?>
				<nav class="social-navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'social',
						'depth'          => 1,
						'fallback_cb'    => false
					) );?>
				</nav><!-- .social-navigation -->
			<?php } ?>
		</div><!-- .footer-bottom -->
	</div><!-- .container -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
