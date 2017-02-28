<?php
/**
 * Deprecated functions and hooks in this theme.
 *
 * @package  Deprecated
 * @category Core
 * @author   GoDaddy
 * @since    1.0.0
 */

/**
 * Mark a function as deprecated.
 *
 * This function is to be used in every Primer function that is deprecated.
 *
 * @access private
 * @link   https://developer.wordpress.org/reference/functions/_deprecated_function/
 * @since  NEXT
 *
 * @param string $name     The function that was called.
 * @param string $version  The theme version that deprecated the function.
 * @param string $alt_name (optional) The function that should be called instead. Default is `null`.
 * @param string $theme    (optional) The theme that deprecated the function. Default is `null` which defaults to 'Primer'.
 */
function _primer_deprecated_function( $name, $version, $alt_name = null, $theme = null ) {

	/**
	 * Filters whether to trigger an error for deprecated functions.
	 *
	 * @link  https://developer.wordpress.org/reference/hooks/deprecated_function_trigger_error/
	 * @since NEXT
	 *
	 * @var bool Default is `true`.
	 */
	if ( (bool) apply_filters( 'deprecated_function_trigger_error', true ) ) {

		_primer_deprecated( $name, $version, $alt_name, $theme );

	}

}

/**
 * Mark a hook as deprecated.
 *
 * This function is to be used in every Primer hook that is deprecated.
 *
 * @access private
 * @link   https://developer.wordpress.org/reference/functions/_deprecated_hook/
 * @since  NEXT
 *
 * @param string $name     The hook that was called.
 * @param string $version  The theme version that deprecated the hook.
 * @param string $alt_name (optional) The hook that should be called instead. Default is `null`.
 * @param string $theme    (optional) The theme that deprecated the hook. Default is `null` which defaults to 'Primer'.
 * @param string $message  (optional) A message regarding the change. Default is `null`.
 */
function _primer_deprecated_hook( $name, $version, $alt_name = null, $theme = null, $message = null ) {

	/**
	 * Filters whether to trigger an error for deprecated hooks.
	 *
	 * @link  https://developer.wordpress.org/reference/hooks/deprecated_hook_trigger_error/
	 * @since NEXT
	 *
	 * @var bool Default is `true`.
	 */
	if ( (bool) apply_filters( 'deprecated_hook_trigger_error', true ) ) {

		_primer_deprecated( $name, $version, $alt_name, $theme, $message );

	}

}

/**
 * Marks a function or hook as deprecated and throws a notice.
 *
 * The default behavior is to trigger a user error when `WP_DEBUG` is `true`.
 *
 * @access private
 * @since  NEXT
 *
 * @param string $name     The item that was called.
 * @param string $version  The theme version that deprecated the item.
 * @param string $alt_name (optional) The item that should be called instead. Default is `null`.
 * @param string $theme    (optional) The theme that deprecated the item. Default is `null` which defaults to 'Primer'.
 * @param string $message  (optional) A message regarding the change. Default is `null`.
 */
function _primer_deprecated( $name, $version, $alt_name = null, $theme = null, $message = null ) {

	if ( ! WP_DEBUG ) {

		return;

	}

	// @codingStandardsIgnoreStart
	$with_alt = '%1$s is <strong>deprecated</strong> since %2$s version %3$s! Use %4$s instead.';
	$with_alt = function_exists( '_x' ) ? _x( $with_alt, '1. PHP function name, 2. theme name, 3. version number, 4. alternative function name', 'primer' ) : $with_alt;
	// @codingStandardsIgnoreEnd

	// @codingStandardsIgnoreStart
	$without_alt = '%1$s is <strong>deprecated</strong> since %2$s version %3$s with no alternative available.';
	$without_alt = function_exists( '_x' ) ? _x( $without_alt, '1. PHP function name, 2. theme name, 3. version number', 'primer' ) : $without_alt;
	// @codingStandardsIgnoreEnd

	$string  = ( $alt_name ) ? $with_alt : $without_alt;
	$theme   = ! empty( $theme ) ? $theme : esc_html__( 'Primer', 'primer' );
	$message = ! empty( $message ) ? ' ' . $message : null;

	// @codingStandardsIgnoreStart
	trigger_error( sprintf( $string, esc_html( $name ), esc_html( $theme ), esc_html( $version ), esc_html( $alt_name ) ) . $message );
	// @codingStandardsIgnoreEnd

}

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @deprecated NEXT No longer supported as the pagination function. Use `primer_pagination()` instead.
 * @global     WP_Query $wp_query
 * @since      1.0.0
 */
function primer_paging_nav() {

	_primer_deprecated_function( __FUNCTION__ . '()', '@NEXT', 'primer_pagination()' );

	global $wp_query;

	if ( ! isset( $wp_query->max_num_pages ) || $wp_query->max_num_pages < 2 ) {

		return;

	}

	?>
	<nav class="navigation paging-navigation">

		<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'primer' ); ?></h2>

		<div class="nav-links">

		<?php if ( get_next_posts_link() ) : ?>

			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'primer' ) ); ?></div>

		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>

			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'primer' ) ); ?></div>

		<?php endif; ?>

		</div><!-- .nav-links -->

	</nav><!-- .navigation -->
	<?php

}
