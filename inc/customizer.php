<?php
/**
 * Atomic Blocks Theme Customizer
 *
 * @package Atomic Blocks
 */

add_action( 'customize_register', 'atomic_blocks_register' );

if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && ! is_customize_preview() ) {
	return;
}

/**
 * Sanitize text
 */
function atomic_blocks_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}


/**
 * Sanitize range slider
 */
function atomic_blocks_sanitize_range( $input ) {
	filter_var( $input, FILTER_FLAG_ALLOW_FRACTION );
	return ( $input );
}


/**
 * Sanitize select
 */
function atomic_blocks_sanitize_select( $input, $setting ) {
	$input = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


/**
 * Get the footer tagline text
 */
function atomic_blocks_footer_tagline() {
	return wp_kses_post( get_theme_mod( 'atomic_blocks_footer_text' ) );
}


/**
 * Get the blog name
 */
function atomic_blocks_blog_name() {
	return get_bloginfo( 'name', 'display' );
}


/**
 * Get the blog description
 */
function atomic_blocks_blog_description() {
	return get_bloginfo( 'description', 'display' );
}


/**
 * @param WP_Customize_Manager $wp_customize
 */
function atomic_blocks_register( $wp_customize ) {

	/**
	 * Theme Options Panel
	 */
	$wp_customize->add_section( 'atomic_blocks_theme_options', array(
		'priority'   => 1,
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'Theme Options', 'atomic-blocks' ),
	) );

	/**
	 * Accent Color
	 */
	$wp_customize->add_setting( 'atomic_blocks_button_color', array(
		'default'           => '#5a3fd6',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'atomic_blocks_button_color', array(
		'label'       => esc_html__( 'Accent Color', 'atomic-blocks' ),
		'section'     => 'colors',
		'settings'    => 'atomic_blocks_button_color',
		'description' => esc_html__( 'Change the accent color of buttons and various typographical elements.', 'atomic-blocks' ),
		'priority'    => 5
	) ) );


	/**
	 * Content Width
	 */
	$wp_customize->add_setting( 'atomic_blocks_content_width', array(
		'default'           => '70',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'atomic_blocks_sanitize_range',
	) );

	$wp_customize->add_control( 'atomic_blocks_content_width', array(
		'type'            => 'range',
		'priority'        => 10,
		'section'         => 'atomic_blocks_theme_options',
		'label'           => esc_html__( 'Content Width', 'atomic-blocks' ),
		'description'     => esc_html__( 'Adjust the width of the content area.', 'atomic-blocks' ),
		'input_attrs' => array(
			'min'   => 50,
			'max'   => 100,
			'step'  => 1,
			'style' => 'width: 100%',
		),
	) );

	
	/**
	 * Search Icon
	 */
	$wp_customize->add_setting( 'atomic_blocks_search_icon', array(
		'default'           => 'enabled',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'atomic_blocks_sanitize_select',
	));

	$wp_customize->add_control( 'atomic_blocks_search_icon', array(
		'settings'        => 'atomic_blocks_search_icon',
		'label'           => esc_html__( 'Search Icon', 'atomic-blocks' ),
		'description'     => esc_html__( 'Add a search icon to your header menu area.', 'atomic-blocks' ),
		'section'         => 'atomic_blocks_theme_options',
		'type'            => 'select',
		'priority'        => 13,
		'choices'         => array(
			'enabled'  => esc_html__( 'Enabled', 'atomic-blocks' ),
			'disabled'  => esc_html__( 'Disabled', 'atomic-blocks' ),
		),
	));

	
	/**
	 * Font Style
	 */
	$wp_customize->add_setting( 'atomic_blocks_font_style', array(
		'default'           => 'sans',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'atomic_blocks_sanitize_select',
	));

	$wp_customize->add_control( 'atomic_blocks_font_style', array(
		'settings'        => 'atomic_blocks_font_style',
		'label'           => esc_html__( 'Font Style', 'atomic-blocks' ),
		'description'     => esc_html__( 'Choose the font style used across your site.', 'atomic-blocks' ),
		'section'         => 'atomic_blocks_theme_options',
		'type'            => 'select',
		'priority'        => 15,
		'choices'         => array(
			'sans'  => esc_html__( 'Sans Serif', 'atomic-blocks' ),
			'serif'  => esc_html__( 'Serif', 'atomic-blocks' ),
		),
	));


	/**
	 * Body Font Size
	 */
	$wp_customize->add_setting( 'atomic_blocks_font_size', array(
		'default'           => '20',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'atomic_blocks_sanitize_range',
	) );

	$wp_customize->add_control( 'atomic_blocks_font_size', array(
		'type'            => 'range',
		'priority'        => 20,
		'section'         => 'atomic_blocks_theme_options',
		'label'           => esc_html__( 'Body Font Size', 'atomic-blocks' ),
		'description'     => esc_html__( 'Adjust the size of the main body font.', 'atomic-blocks' ),
		'input_attrs' => array(
			'min'   => 16,
			'max'   => 24,
			'step'  => 1,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Title Font Size
	 */
	$wp_customize->add_setting( 'atomic_blocks_title_font_size', array(
		'default'           => '50',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'atomic_blocks_sanitize_range',
	) );

	$wp_customize->add_control( 'atomic_blocks_title_font_size', array(
		'type'            => 'range',
		'priority'        => 25,
		'section'         => 'atomic_blocks_theme_options',
		'label'           => esc_html__( 'Title Font Size', 'atomic-blocks' ),
		'description'     => esc_html__( 'Adjust the size of the post and page titles.', 'atomic-blocks' ),
		'input_attrs' => array(
			'min'   => 34,
			'max'   => 70,
			'step'  => 1,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Footer Tagline
	 */
	$wp_customize->add_setting( 'atomic_blocks_footer_text', array(
		'sanitize_callback' => 'atomic_blocks_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'atomic_blocks_footer_text', array(
			'label'       => esc_html__( 'Footer Tagline', 'atomic-blocks' ),
			'section'     => 'atomic_blocks_theme_options',
			'settings'    => 'atomic_blocks_footer_text',
			'description' => esc_html__( 'Change the text that appears in the footer tagline at the bottom of your site.', 'atomic-blocks' ),
			'type'        => 'text',
			'priority'    => 30
		)
	);

	$wp_customize->selective_refresh->add_partial( 'atomic_blocks_footer_text', array(
        'selector'            => '.site-info',
        'container_inclusive' => false,
        'render_callback'     => atomic_blocks_footer_tagline(),
    ) );
}


/**
 * Adjust header height based on theme option
 */
function atomic_blocks_css_output() {
	// Theme Options
	$accent_color    = esc_html( get_theme_mod( 'atomic_blocks_button_color', '#5a3fd6' ) );
	$content_width   = esc_html( get_theme_mod( 'atomic_blocks_content_width', '70' ).'%' );
	$font_size       = esc_html( get_theme_mod( 'atomic_blocks_font_size', '20' ).'px' );
	$title_font_size = esc_html( get_theme_mod( 'atomic_blocks_title_font_size', '50' ).'px' );
	$font_style 	 = esc_html( get_theme_mod( 'atomic_blocks_font_style', 'sans' ) );

	if( $font_style == 'serif' ) {
		$title_font_face = "'Frank Ruhl Libre', serif";	
	} else {
		$title_font_face = "'Nunito Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;";	
	}

	// Check for styles before outputting
	if ( $accent_color ) {

	$atomic_blocks_custom_css = "

	button,
	input[type='button'],
	input[type='submit'],
	.button,
	.page-numbers.current,
	.page-numbers:hover,
	#page #infinite-handle button,
	#page #infinite-handle button:hover,
	.comment-navigation a,
	.su-button,
	.mobile-navigation,
	.toggle-active {
	      background-color: $accent_color;
	}

	.entry-content p a,
	.entry-content p a:hover,
	.header-text a,
	.header-text a:hover,
	.entry-content .meta-list a,
	.post-navigation a:hover .post-title,
	.entry-header .entry-title a:hover,
	#page .more-link:hover,
	.site-footer a,
	.main-navigation a:hover, 
	.main-navigation ul li.current-menu-item a, 
	.main-navigation ul li.current-page-item a {
		color: $accent_color;
	}

	.entry-header .entry-title a:hover {
		box-shadow: inset 0 -4px 0 $accent_color;
	}

	.entry-content p a,
	.header-text a {
		box-shadow: inset 0 -1px 0 $accent_color;
	}

	.entry-content p a:hover,
	.header-text a:hover {
		box-shadow: inset 0 -2px 0 $accent_color;
	}

	@media (min-width: 1000px) {
		#primary {
			width: $content_width;
		}
	}

	@media (min-width: 1000px) {
		body {
			font-size: $font_size;
		}
	}

	@media (min-width: 1000px) {
		.entry-header .entry-title {
			font-size: $title_font_size;
		}
	}
 
	h1, h2, h3, h4, h5, h6, body, button, 
	input[type='button'],
	input[type='reset'],
	input[type='submit'],
	.button,
	#page #infinite-handle button {
		font-family: $title_font_face;
	}

	";

	wp_add_inline_style( 'atomic-blocks-style', $atomic_blocks_custom_css );
} }
add_action( 'wp_enqueue_scripts', 'atomic_blocks_css_output' );


/**
 * Add font class to admin body
 */
function atomic_blocks_admin_font( $classes ) {

	$font_style = get_theme_mod( 'atomic_blocks_font_style', 'sans' );

	if ( $font_style == 'serif' ) {
		$font_class[] = 'serif-font-option';
	} else {
		$font_class[] = 'sans-font-option';
	}

	return $classes . ' ' . implode( ' ', $font_class ) . ' ';
}
add_filter( 'admin_body_class', 'atomic_blocks_admin_font' );


/**
 * Add postMessage support and selective refresh for site title and description.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function atomic_blocks_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'header_site_title', array(
        'selector' => '.site-title a',
        'settings' => array( 'blogname' ),
        'render_callback' => atomic_blocks_blog_name(),
    ) );

	$wp_customize->selective_refresh->add_partial( 'header_site_description', array(
        'selector' => '.site-description',
        'settings' => array( 'blogdescription' ),
        'render_callback' => atomic_blocks_blog_description(),
    ) );
}
add_action( 'customize_register', 'atomic_blocks_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function atomic_blocks_customize_preview_js() {
	wp_enqueue_script( 'atomic_blocks_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20180228', true );
}
add_action( 'customize_preview_init', 'atomic_blocks_customize_preview_js' );


/**
 * Send customization styling to block editor
 */
function atomic_blocks_gutenberg_styles() {
	// Theme Options
	$accent_color    = esc_html( get_theme_mod( 'atomic_blocks_button_color', '#5a3fd6' ) );
	$font_size       = esc_html( get_theme_mod( 'atomic_blocks_font_size', '20' ).'px' );
	$title_font_size = esc_html( get_theme_mod( 'atomic_blocks_title_font_size', '50' ).'px' );

	// CSS for block editor
	$css  = '';
	$css .= '#editor .edit-post-visual-editor textarea.editor-post-title__input { font-size: ' . esc_attr( $title_font_size ) . '; }';
	$css .= '#editor .edit-post-visual-editor p { font-size: ' . esc_attr( $font_size ) . '; }';
	$css .= '
		#editor .editor-rich-text__tinymce a { 
			box-shadow: inset 0 -1px 0 ' . esc_attr( $accent_color ) . ';
			color: ' . esc_attr( $accent_color ) . ';
		}
		#editor .editor-rich-text__tinymce a:hover,
		.ab-block-post-grid h2 a:hover,
		.ab-block-post-grid .ab-block-post-grid-link:hover {
			color: ' . esc_attr( $accent_color ) . ';
			box-shadow: inset 0 -2px 0 ' . esc_attr( $accent_color ) . ';
		}
	';
	return wp_strip_all_tags( $css );	
}