<?php
/**
 * Atomic Blocks functions and definitions
 *
 * @package Atomic Blocks
 */


if ( ! function_exists( 'atomic_blocks_setup' ) ) :
/**
 * Sets up Atomic Blocks's defaults and registers support for various WordPress features
 */
function atomic_blocks_setup() {

	/**
	 * Load Getting Started page
	 */
	if( ! function_exists( 'atomic_blocks_loader' ) ) {
		require_once( get_template_directory() . '/inc/admin/getting-started/getting-started.php' );
	}

	/** 
	 * Add styles to post editor
	 */
	add_editor_style( array( 'editor-style.css', atomic_blocks_fonts_url() ) );

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'atomic-blocks', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Post thumbnail support and image sizes
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Add title output
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Custom Background support
	 */
	$defaults = array(
		'default-color' => 'ffffff'
	);
	add_theme_support( 'custom-background', $defaults );

	/**
	 * Add wide image support
	 */
	add_theme_support( 'align-wide' );

	/**
	 * Selective Refresh for Customizer
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add excerpt support to pages
	add_post_type_support( 'page', 'excerpt' );

	// Featured image
	add_image_size( 'atomic-blocks-featured-image', 1200 );

	// Wide featured image
	add_image_size( 'atomic-blocks-featured-image-wide', 1400 );

	// Logo size
	add_image_size( 'atomic-blocks-logo', 300 );

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'atomic-blocks' ),
		'social'  => esc_html__( 'Social Icon Menu', 'atomic-blocks' ),
	) );

	/**
	 * Add Site Logo feature
	 */
	add_theme_support( 'custom-logo', array(
		'header-text' => array( 'titles-wrap' ),
		'size'        => 'atomic-blocks-logo',
	) );

	/**
	 * Enable HTML5 markup
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'gallery',
	) );

	/**
	 * Enable post formats
	 */
	add_theme_support( 'post-formats', array( 'video', 'gallery' ) );
}
endif; // atomic_blocks_setup
add_action( 'after_setup_theme', 'atomic_blocks_setup' );


/**
 * Redirect to Getting Started page on theme activation
 */
function atomic_blocks_redirect_on_activation() {
	global $pagenow;

	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

		wp_redirect( admin_url( "admin.php?page=atomic-blocks" ) );

	}
}
add_action( 'admin_init', 'atomic_blocks_redirect_on_activation' );


/**
 * Add Carousel image size to gallery select
 */
function atomic_blocks_carousel_image_sizes( $sizes ) {
	$addsizes = array(
		"atomic-blocks-portfolio-carousel" => esc_html__( 'Carousel', 'atomic-blocks' ),
	);
	$newsizes = array_merge( $sizes, $addsizes );
	return $newsizes;
}
add_filter( 'image_size_names_choose', 'atomic_blocks_carousel_image_sizes' );



/**
 * Set the content width based on the theme's design and stylesheet
 */
function atomic_blocks_content_width() {
	if ( has_post_format( 'gallery' ) ) {
		$GLOBALS['content_width'] = apply_filters( 'atomic_blocks_content_width', 1400 );
	} else {
		$GLOBALS['content_width'] = apply_filters( 'atomic_blocks_content_width', 905 );
	}
}
add_action( 'after_setup_theme', 'atomic_blocks_content_width', 0 );


/**
 * Gets the gallery shortcode data from post content.
 */
function atomic_blocks_gallery_data() {
	global $post;
	$pattern = get_shortcode_regex();
	if (   preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
		&& array_key_exists( 2, $matches )
		&& in_array( 'gallery', $matches[2] ) )
	{

		return $matches;
	}
}


/**
 * Disply the featured image, gallery or video associated with the post
 *
 * @since Atomic Blocks 1.0
 */
function atomic_blocks_post_media() {
	global $post, $wp_embed;

	// Get the post content
	$content = apply_filters( 'the_content', $post->post_content );

	// Check for video post format content
	$media = get_media_embedded_in_content( $content );

	// If it's a video format, get the first video embed from the post to replace the featured image
	if ( has_post_format( 'video' ) && ! empty( $media ) ) {

		echo '<div class="featured-video">';
			echo $media[0];
		echo '</div>';

	}
	
	else if ( has_post_thumbnail() ) {
		
		$page_template = get_post_meta( $post->ID, '_wp_page_template', true );

		if ( $page_template == 'templates/template-wide-image.php' ) {
			$featured_image = get_the_post_thumbnail_url( $post, 'atomic-blocks-featured-image-wide' );
		} else {
			$featured_image = get_the_post_thumbnail_url( $post, 'atomic-blocks-featured-image' );
		}

		// Otherwise get the featured image
		echo '<div class="featured-image">';
			if ( is_single() ) { ?>
				<img src="<?php echo $featured_image; ?>" alt="<?php the_title(); ?>" />
				<?php } else { ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark"><img src="<?php echo $featured_image; ?>" alt="<?php the_title(); ?>" /></a>
			<?php }
		echo '</div>';

	} wp_reset_postdata(); ?>

<?php }


/**
 * If the post has a carousel gallery, remove the first gallery from the post
 *
 * @since Atomic Blocks 1.0
 */
function atomic_blocks_filtered_content() {

	global $post, $wp_embed;

	$content = get_the_content( esc_html__( 'Read More', 'atomic-blocks' ) );

	if ( has_post_format( 'gallery' ) ) {

		$gallery_data = atomic_blocks_gallery_data();

		// Remove the first gallery from the post since we're using it in place of the featured image
		if ( $gallery_data && is_array( $gallery_data ) ) {
			$content = str_replace( $gallery_data[0][0], '', $content );
		}
	}

	if ( has_post_format( 'video' ) ) {

		// Remove the first video embed from the post since we're using it in place of the featured image
		if ( ! empty( $wp_embed->last_url ) ) {

			$content = str_replace( $wp_embed->last_url, '', $content );

		} else {

			$video = get_media_embedded_in_content( $content );
			$content = str_replace( $video, '', $content );
		}
	}

	echo apply_filters( 'the_content', $content );
}


/**
 * Register widget area
 */
function atomic_blocks_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 1', 'atomic-blocks' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Widgets added here will appear in the left column of the footer.', 'atomic-blocks' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 2', 'atomic-blocks' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Widgets added here will appear in the center column of the footer.', 'atomic-blocks' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer - Column 3', 'atomic-blocks' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Widgets added here will appear in the right column of the footer.', 'atomic-blocks' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'atomic_blocks_widgets_init' );


/**
 * Return the Google font stylesheet URL
 */
if ( ! function_exists( 'atomic_blocks_fonts_url' ) ) :
function atomic_blocks_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by these fonts, translate this to 'off'. Do not translate
	 * into your own language.
	 */

	$font_style = get_theme_mod( 'atomic_blocks_font_style', 'sans' );

	if ( $font_style == 'serif' ) {
		$frank = esc_html_x( 'on', 'Frank Ruhl Libre font: on or off', 'atomic-blocks' );

		if ( 'off' !== $frank ) {
			$font_families = array();

			if ( 'off' !== $frank )
				$font_families[] = 'Frank Ruhl Libre:400,700';
		}
	} else {
		$muli = esc_html_x( 'on', 'Muli font: on or off', 'atomic-blocks' );
		$nunito_sans = esc_html_x( 'on', 'Nunito Sans font: on or off', 'atomic-blocks' );

		if ( 'off' !== $nunito_sans || 'off' !== $muli ) {
			$font_families = array();

			if ( 'off' !== $muli )
				$font_families[] = 'Muli:700';

			if ( 'off' !== $nunito_sans )
				$font_families[] = 'Nunito Sans:400,400i,600,700';
		}
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );

	return $fonts_url;
}
endif;


/**
 * Enqueue scripts and styles
 */
function atomic_blocks_scripts() {

	wp_enqueue_style( 'atomic-blocks-style', get_stylesheet_uri() );

	/**
	* Load fonts from Google
	*/
	wp_enqueue_style( 'atomic-blocks-fonts', atomic_blocks_fonts_url(), array(), null );

	/**
	 * FontAwesome Icons stylesheet
	 */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/inc/fontawesome/css/font-awesome.css", array(), '4.4.0', 'screen' );

	/**
	 * Load Atomic Blocks's javascript
	 */
	wp_enqueue_script( 'atomic-blocks-js', get_template_directory_uri() . '/js/atomic-blocks.js', array( 'jquery' ), '1.0', true );

	/**
	 * Load fitvids javascript
	 */
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), '1.1', true );

	/**
	 * Masonry
	 */
	wp_enqueue_script( 'masonry' );

	/**
	 * Localizes the atomic-blocks-js file
	 */
	wp_localize_script( 'atomic-blocks-js', 'atomic_blocks_js_vars', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	) );

	/**
	 * Load the comment reply script
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'atomic_blocks_scripts' );


/**
 * Enqueue admin scripts and styles
 */
function atomic_blocks_admin_scripts() {

	/**
	* Load editor fonts from Google
	*/
	wp_enqueue_style( 'atomic-blocks-admin-fonts', atomic_blocks_fonts_url(), array(), null );
	
}
add_action( 'admin_enqueue_scripts', 'atomic_blocks_admin_scripts', 5 );


/**
 * Enqueue shared styles for frontend and backend
 */
function atomic_blocks_shared_styles() {
	/**
	 * Shared block styles
	 */
	wp_enqueue_style( 'atomic-blocks-shared-styles', get_template_directory_uri() . "/common.css", array(), '1.0', 'screen' );
}
add_action( 'wp_enqueue_scripts', 'atomic_blocks_shared_styles' );
add_action( 'enqueue_block_editor_assets', 'atomic_blocks_shared_styles' );


/**
 * Load block editor styles
 */
function atomic_blocks_block_editor_styles() { 
	wp_enqueue_style( 'atomic-blocks-block-editor-styles', get_template_directory_uri() . '/block-editor.css'); 
}
add_action( 'enqueue_block_editor_assets', 'atomic_blocks_block_editor_styles' );


/**
 * Custom template tags for Atomic Blocks
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Customizer theme options
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Load Jetpack compatibility file
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Add button class to next/previous post links
 */
function atomic_blocks_posts_link_attributes() {
	return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'atomic_blocks_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'atomic_blocks_posts_link_attributes' );


/**
 * Add layout style class to body
 */
function atomic_blocks_layout_class( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if( is_single() && has_post_thumbnail() || is_page() && has_post_thumbnail() ) {
		$classes[] = 'has-featured-image';
	}

	$featured_image = get_theme_mod( 'atomic_blocks_featured_image_style', 'wide' );

	if ( $featured_image == 'wide' ) {
		$classes[] = 'featured-image-wide';
	}

	return $classes;
}
add_filter( 'body_class', 'atomic_blocks_layout_class' );


/**
 * Add featured image class to posts
 */
function atomic_blocks_featured_image_class( $classes ) {
	global $post;

	$classes[] = 'post';

	// Check for featured image
	$classes[] = has_post_thumbnail() ? 'with-featured-image' : 'without-featured-image';

	$page_template = get_post_meta( $post->ID, '_wp_page_template', true );

	if ( $page_template == 'templates/template-wide-image.php' ) {
		$classes[] = 'has-wide-image';
	}

	return $classes;
}
add_filter( 'post_class', 'atomic_blocks_featured_image_class' );


/**
 * Adjust the grid excerpt length for portfolio items
 */
function atomic_blocks_search_excerpt_length() {
	return 40;
}


/**
 * Add an ellipsis read more link
 */
function atomic_blocks_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'atomic_blocks_excerpt_more' );


/**
 * Full size image on attachment pages
 */
function atomic_blocks_attachment_size( $p ) {
	if ( is_attachment() ) {
		return '<p>' . wp_get_attachment_link( 0, 'full-size', false ) . '</p>';
	}
}
add_filter( 'prepend_attachment', 'atomic_blocks_attachment_size' );


/**
 * Add a js class
 */
function atomic_blocks_html_js_class () {
    echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}
add_action( 'wp_head', 'atomic_blocks_html_js_class', 1 );
