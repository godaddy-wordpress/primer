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
 * Marks a function or hook as deprecated and throws a notice.
 *
 * The default behavior is to trigger a user error when `WP_DEBUG` is `true`.
 *
 * Note: This function's access is marked private. This means it is not
 * intended to be used by plugin or theme developers, and should only be
 * used by other Primer functions. This function could be changed or even
 * removed in the future without concern for backward compatiblity and is
 * only documented here for completeness.
 *
 * @access private
 * @since  1.6.0
 *
 * @param string $name        The item that was called.
 * @param string $version     The theme version that deprecated the item.
 * @param string $replacement (optional) The item that should be called instead. Default is `null`.
 * @param string $theme       (optional) The theme that deprecated the item. Default is `null` which defaults to 'Primer'.
 * @param string $message     (optional) A message regarding the change. Default is `null`.
 */
function primer_deprecated( $name, $version, $replacement = null, $theme = null, $message = null ) {

	if ( ! WP_DEBUG ) {

		return;

	}

	// Note: Translation text must be a string or the themecheck will flag it.
	$with_replacement    = function_exists( '__' ) ? /* translators: 1. PHP function name, 2. theme name, 3. version number, 4. alternative function name */ __( '%1$s is <strong>deprecated</strong> since %2$s version %3$s! Use %4$s instead.', 'primer' ) : '%1$s is <strong>deprecated</strong> since %2$s version %3$s! Use %4$s instead.';
	$without_replacement = function_exists( '__' ) ? /* translators: 1. PHP function name, 2. theme name, 3. version number */ __( '%1$s is <strong>deprecated</strong> since %2$s version %3$s with no alternative available.', 'primer' ) : '%1$s is <strong>deprecated</strong> since %2$s version %3$s with no alternative available.';

	$string  = ( $replacement ) ? $with_replacement : $without_replacement;
	$theme   = ! empty( $theme ) ? $theme : esc_html__( 'Primer', 'primer' );
	$message = ! empty( $message ) ? ' ' . $message : null;

	// @codingStandardsIgnoreStart
	trigger_error( sprintf( $string, esc_html( $name ), esc_html( $theme ), esc_html( $version ), esc_html( $replacement ) ) . $message );
	// @codingStandardsIgnoreEnd

}

/**
 * Mark a function as deprecated.
 *
 * This function is to be used in every Primer function that is deprecated.
 *
 * Note: This function's access is marked private. This means it is not
 * intended to be used by plugin or theme developers, and should only be
 * used by other Primer functions. This function could be changed or even
 * removed in the future without concern for backward compatiblity and is
 * only documented here for completeness.
 *
 * @access private
 * @link   https://developer.wordpress.org/reference/functions/_deprecated_function/
 * @since  1.6.0
 *
 * @param string $function    The function that was called.
 * @param string $version     The theme version that deprecated the function.
 * @param string $replacement (optional) The function that should be called instead. Default is `null`.
 * @param string $theme       (optional) The theme that deprecated the function. Default is `null` which defaults to 'Primer'.
 * @param string $message     (optional) A message regarding the change. Default is `null`.
 */
function primer_deprecated_function( $function, $version, $replacement = null, $theme = null, $message = null ) {

	if ( (bool) apply_filters( 'deprecated_function_trigger_error', true ) ) {

		primer_deprecated( $function, $version, $replacement, $theme, $message );

	}

}

/**
 * Mark a filter hook as deprecated.
 *
 * This function is a replacement for `apply_filters()` that is used to
 * deprecate Primer filter hooks.
 *
 * Note: This function's access is marked private. This means it is not
 * intended to be used by plugin or theme developers, and should only be
 * used by other Primer functions. This function could be changed or even
 * removed in the future without concern for backward compatiblity and is
 * only documented here for completeness.
 *
 * @access private
 * @link   https://developer.wordpress.org/reference/functions/apply_filters_deprecated/
 * @since  1.8.0
 *
 * @param string $tag         The name of the filter hook.
 * @param array  $args        Array of additional function arguments to be passed to `apply_filters()`.
 * @param string $version     The theme version that deprecated the hook.
 * @param string $replacement (optional) The hook that should be called instead. Default is `null`.
 * @param string $theme       (optional) The theme that deprecated the hook. Default is `null` which defaults to 'Primer'.
 * @param string $message     (optional) A message regarding the change. Default is `null`.
 *
 * @return mixed
 */
function primer_apply_filters_deprecated( $tag, $args, $version, $replacement = null, $theme = null, $message = null ) {

	if ( ! has_filter( $tag ) ) {

		return $args[0];

	}

	if ( (bool) apply_filters( 'deprecated_hook_trigger_error', true ) ) {

		primer_deprecated( $tag, $version, $replacement, $theme, $message );

	}

	return apply_filters_ref_array( $tag, $args );

}

/**
 * Mark an action hook as deprecated.
 *
 * This function is a replacement for `do_action()` that is used to
 * deprecate Primer action hooks.
 *
 * Note: This function's access is marked private. This means it is not
 * intended to be used by plugin or theme developers, and should only be
 * used by other Primer functions. This function could be changed or even
 * removed in the future without concern for backward compatiblity and is
 * only documented here for completeness.
 *
 * @access private
 * @link   https://developer.wordpress.org/reference/functions/do_action_deprecated/
 * @since  1.8.0
 *
 * @param string $tag         The name of the action hook.
 * @param array  $args        Array of additional function arguments to be passed to `do_action()`.
 * @param string $version     The theme version that deprecated the hook.
 * @param string $replacement (optional) The hook that should be called instead. Default is `null`.
 * @param string $theme       (optional) The theme that deprecated the hook. Default is `null` which defaults to 'Primer'.
 * @param string $message     (optional) A message regarding the change. Default is `null`.
 */
function primer_do_action_deprecated( $tag, $args, $version, $replacement = null, $theme = null, $message = null ) {

	if ( ! has_action( $tag ) ) {

		return;

	}

	if ( (bool) apply_filters( 'deprecated_hook_trigger_error', true ) ) {

		primer_deprecated( $tag, $version, $replacement, $theme, $message );

	}

	do_action_ref_array( $tag, $args );

}

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @deprecated 1.6.0 No longer supported as the pagination function. Use `primer_pagination()` instead.
 * @global     WP_Query $wp_query
 * @since      1.0.0
 */
function primer_paging_nav() {

	primer_deprecated_function( __FUNCTION__ . '()', '1.6.0', 'primer_pagination()' );

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
