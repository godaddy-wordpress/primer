<?php
/**
 * Child Theme compatibility.
 *
 * @package    Compatibility
 * @subpackage ChildThemes
 * @category   Core
 * @author     GoDaddy
 * @since      1.0.0
 */

/**
 * Compare against the current Primer child theme version.
 *
 * This function accepts the same `$version` and `$operator` formats as
 * the native `version_compare()` function in PHP and will always return
 * `false` if the `PRIMER_CHILD_VERSION` constant is empty.
 *
 * @link  https://secure.php.net/manual/en/function.version-compare.php
 * @since 1.5.0
 *
 * @param  string $version  Version number to compare against the Primer child version.
 * @param  string $operator Test for a particular relationship. The possible operators are: `<`, `lt`, `<=`, `le`, `>`, `gt`, `>=`, `ge`, `==`, `=`, `eq`, `!=`, `<>`, `ne` respectively.
 *
 * @return bool Returns `true` if the provided version's relationship to the Primer child version is the one specified by the operator, otherwise `false`.
 */
function primer_child_version_compare( $version, $operator ) {

	return ( is_child_theme() && PRIMER_CHILD_VERSION && version_compare( PRIMER_CHILD_VERSION, $version, $operator ) );

}

/**
 * Return a value for a special child theme compatibility condition.
 *
 * Note: This function's access is marked private. This means it is not
 * intended to be used by plugin or theme developers, and should only be
 * used by other Primer functions. This function could be changed or even
 * removed in the future without concern for backward compatiblity and is
 * only documented here for completeness.
 *
 * This function helps to preserve backward compatiblity when the Primer
 * parent theme is updated, but the child theme is not. It is especially
 * useful for preserving child theme overrides on hooks where a priority
 * in Primer needed to change.
 *
 * It works by checking the current child theme version and compatibility
 * key against a special compatibility array. If the current version is
 * LESS THAN a flagged version for the current theme, AND there is a key
 * match in that version, then the compatibility value is returned.
 *
 * If no special compatibility conditions are met, the default value
 * (2nd parameter) is always returned.
 *
 * @access private
 * @since  1.6.0
 *
 * @param  string $key   The compatibility key.
 * @param  mixed  $value Default value to always return when no special compatibility condition exists.
 *
 * @return mixed
 */
function primer_child_compat( $key, $value ) {

	if ( ! is_child_theme() || ! PRIMER_CHILD_VERSION ) {

		return $value;

	}

	$compat = array(
		'activation'   => array(
			'1.1.0' => array(
				'header__add_site_title'               => 10,
				'header__add_hero'                     => 10,
				'after_header__add_primary_navigation' => 10,
				'after_header__add_page_title'         => 10,
				'wc__cart_menu_item'                   => false,
			),
		),
		'ascension'    => array(
			'1.1.0' => array(
				'header__add_site_title'               => 10,
				'header__add_hero'                     => 10,
				'after_header__add_primary_navigation' => 10,
				'after_header__add_page_title'         => 10,
				'wc__cart_menu_item'                   => false,
			),
		),
		'escapade'     => array(
			'1.1.0' => array(
				'header__add_site_title'               => 10,
				'header__add_hero'                     => 10,
				'after_header__add_primary_navigation' => 10,
				'after_header__add_page_title'         => 10,
				'wc__cart_menu_item'                   => false,
			),
		),
		'lyrical'      => array(
			'1.1.0' => array(
				'header__add_site_title'               => 10,
				'header__add_hero'                     => 10,
				'after_header__add_primary_navigation' => 10,
				'after_header__add_page_title'         => 10,
				'wc__cart_menu_item'                   => false,
			),
		),
		'mins'         => array(
			'1.1.0' => array(
				'header__add_site_title'               => 10,
				'header__add_hero'                     => 10,
				'after_header__add_primary_navigation' => 10,
				'after_header__add_page_title'         => 10,
				'wc__cart_menu_item'                   => false,
			),
		),
		'scribbles'    => array(
			'1.1.0' => array(
				'header__add_site_title'               => 10,
				'header__add_hero'                     => 10,
				'after_header__add_primary_navigation' => 10,
				'after_header__add_page_title'         => 10,
				'wc__cart_menu_item'                   => false,
			),
		),
		'stout'        => array(
			'1.1.0' => array(
				'header__add_site_title'               => 10,
				'header__add_hero'                     => 10,
				'after_header__add_primary_navigation' => 10,
				'after_header__add_page_title'         => 10,
				'wc__cart_menu_item'                   => false,
			),
		),
		'uptown-style' => array(
			'1.1.0' => array(
				'header__add_site_title'               => 10,
				'header__add_hero'                     => 10,
				'after_header__add_primary_navigation' => 10,
				'after_header__add_page_title'         => 10,
				'wc__cart_menu_item'                   => false,
			),
		),
		'velux'        => array(
			'1.1.0' => array(
				'header__add_site_title'               => 10,
				'header__add_hero'                     => 10,
				'after_header__add_primary_navigation' => 10,
				'after_header__add_page_title'         => 10,
				'wc__cart_menu_item'                   => false,
			),
		),
	);

	/**
	 * Filter the child theme compatibility array.
	 *
	 * @since 1.6.0
	 *
	 * @var array
	 */
	$compat = (array) apply_filters( 'primer_child_compat', $compat );

	$theme = get_option( 'stylesheet', 'primer' );

	if ( empty( $compat[ $theme ] ) || ! is_array( $compat[ $theme ] ) ) {

		return $value;

	}

	foreach ( $compat[ $theme ] as $version => $keys ) {

		if ( primer_child_version_compare( $version, '<' ) && array_key_exists( $key, $keys ) ) {

			return $keys[ $key ];

		}

	}

	return $value;

}
