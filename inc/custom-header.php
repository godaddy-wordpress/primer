<?php
/**
 * Custom header support.
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package Primer
 */

/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so:

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 */

/**
 * Add custom header support.
 *
 * @action after_setup_theme
 *
 * @uses primer_header_style()
 * @uses primer_admin_header_style()
 * @uses primer_admin_header_image()
 *
 * @since 1.0.0
 */
function primer_custom_header_setup() {

	$color_scheme  = primer_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	$args = array(
		'default-image'          => '',
		'default-text-color'     => $default_color,
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'primer_header_style',
		'admin-head-callback'    => 'primer_admin_header_style',
		'admin-preview-callback' => 'primer_admin_header_image',
	);

	/**
	 * Filter the custom header args.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$args = (array) apply_filters( 'primer_custom_header_args', $args );

	add_theme_support( 'custom-header', $args );

}
add_action( 'after_setup_theme', 'primer_custom_header_setup' );

if ( ! function_exists( 'primer_header_style' ) ) {

	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see primer_custom_header_setup()
	 *
	 * @since 1.0.0
	 */
	function primer_header_style() {

		$header_text_color = get_header_textcolor();

		// If no custom options for text are set, let's bail
		// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
		if ( HEADER_TEXTCOLOR == $header_text_color ) {

			return;

		}

		?>
		<style type="text/css">
		<?php if ( 'blank' == $header_text_color ) : ?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php else : ?>
			.site-title a,
			.site-description {
				color: #<?php echo $header_text_color; ?>;
			}
		<?php endif; ?>
		</style>
		<?php

	}

} // primer_header_style

if ( ! function_exists( 'primer_admin_header_style' ) ) {

	/**
	 * Styles the header image displayed on the Appearance > Header admin panel.
	 *
	 * @see primer_custom_header_setup()
	 *
	 * @since 1.0.0
	 */
	function primer_admin_header_style() {

		?>
		<style type="text/css">
			.appearance_page_custom-header #headimg {
				border: none;
			}
			#headimg h1, #desc {}
			#headimg h1 {}
			#headimg h1 a {}
			#desc {}
			#headimg img {}
		</style>
		<?php

	}

} // primer_admin_header_style

if ( ! function_exists( 'primer_admin_header_image' ) ) {

	/**
	 * Custom header image markup displayed on the Appearance > Header admin panel.
	 *
	 * @see primer_custom_header_setup()
	 *
	 * @since 1.0.0
	 */
	function primer_admin_header_image() {

		$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );

		?>
		<div id="headimg">

			<h1 class="displaying-header-text"><a id="name"<?php echo $style // xss ok ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php bloginfo( 'name' ) ?></a></h1>

			<div class="displaying-header-text" id="desc"<?php echo $style // xss ok ?>><?php bloginfo( 'description' ) ?></div>

		<?php if ( get_header_image() ) : ?>

			<img src="<?php header_image() ?>" alt="">

		<?php endif; ?>

		</div>
		<?php

	}

} // primer_admin_header_image
