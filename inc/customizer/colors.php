<?php
/**
 * Customizer Colors functionality.
 *
 * @class    Primer_Customizer_Colors
 * @package  Classes/Customizer
 * @category Class
 * @author   GoDaddy
 * @since    1.0.0
 */
class Primer_Customizer_Colors {

	/**
	 * Array of customizable colors.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $colors = array();

	/**
	 * Array of available color schemes.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $color_schemes = array();

	/**
	 * Class constructor.
	 */
	public function __construct() {

		/**
		 * Filter the registered color settings.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$this->colors = (array) apply_filters(
			'primer_colors',
			array(
				/**
				 * Text colors
				 */
				'header_textcolor'                       => array(
					'label'           => esc_html__( 'Site Title Text', 'primer' ),
					'default'         => '#ffffff',
					'section'         => 'colors-header',
					'active_callback' => 'display_header_text',
					'css'             => array(
						'.site-title a, .site-title a:visited' => array(
							'color' => '%1$s',
						),
					),
					'rgba_css'        => array(
						'.site-title a:hover, .site-title a:visited:hover' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
				),
				'tagline_text_color'                     => array(
					'label'           => esc_html__( 'Tagline Text', 'primer' ),
					'default'         => '#ffffff',
					'section'         => 'colors-header',
					'active_callback' => 'display_header_text',
					'css'             => array(
						'.site-description' => array(
							'color' => '%1$s',
						),
					),
				),
				'hero_text_color'                        => array(
					'label'    => esc_html__( 'Hero Text', 'primer' ),
					'default'  => '#ffffff',
					'section'  => 'colors-header',
					'priority' => 20,
					'css'      => array(
						'.hero,
						.hero .widget h1,
						.hero .widget h2,
						.hero .widget h3,
						.hero .widget h4,
						.hero .widget h5,
						.hero .widget h6,
						.hero .widget p,
						.hero .widget blockquote,
						.hero .widget cite,
						.hero .widget table,
						.hero .widget ul,
						.hero .widget ol,
						.hero .widget li,
						.hero .widget dd,
						.hero .widget dt,
						.hero .widget address,
						.hero .widget code,
						.hero .widget pre,
						.hero .widget .widget-title,
						.hero .page-header h1' =>
						array(
							'color' => '%1$s',
						),
					),
				),
				'menu_text_color'                        => array(
					'label'    => esc_html__( 'Text', 'primer' ),
					'default'  => '#ffffff',
					'section'  => 'colors-menu',
					'css'      => array(
						'.main-navigation ul li a, .main-navigation ul li a:visited, .main-navigation ul li a:hover, .main-navigation ul li a:focus, .main-navigation ul li a:visited:hover' => array(
							'color' => '%1$s',
						),
						'.main-navigation .sub-menu .menu-item-has-children > a::after' => array(
							'border-right-color' => '%1$s',
							'border-left-color'  => '%1$s', // RTL support.
						),
						'.menu-toggle div' => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'.main-navigation ul li a:hover,
						.main-navigation ul li a:focus' =>
						array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
				),
				'heading_text_color'                     => array(
					'label'       => esc_html__( 'Heading Text', 'primer' ),
					'description' => esc_html__( 'Post titles, widget titles, form labels, table headers and buttons.', 'primer' ),
					'default'     => '#353535',
					'section'     => 'colors-content',
					'css'         => array(
						'h1, h2, h3, h4, h5, h6,
						label,
						legend,
						table th,
						dl dt,
						.entry-title, .entry-title a, .entry-title a:visited,
						.widget-title' =>
						array(
							'color' => '%1$s',
						),
					),
					'rgba_css'    => array(
						'.entry-title a:hover, .entry-title a:visited:hover, .entry-title a:focus, .entry-title a:visited:focus, .entry-title a:active, .entry-title a:visited:active' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
					'editor_css'  => array(
						'.editor-styles-wrapper .editor-post-title__block textarea.editor-post-title__input,
						.editor-styles-wrapper .wp-block h1,
						.editor-styles-wrapper .wp-block h2,
						.editor-styles-wrapper .wp-block h3,
						.editor-styles-wrapper .wp-block h4,
						.editor-styles-wrapper .wp-block h5,
						.editor-styles-wrapper .wp-block h6' =>
						array(
							'color' => '%1$s',
						),
					),
				),
				'primary_text_color'                     => array(
					'label'       => esc_html__( 'Primary Text', 'primer' ),
					'description' => esc_html__( 'Paragraphs, lists, menu links, quotes and tables.', 'primer' ),
					'default'     => '#252525',
					'section'     => 'colors-content',
					'css'         => array(
						'body,
						input,
						select,
						textarea,
						input[type="text"]:focus,
						input[type="email"]:focus,
						input[type="url"]:focus,
						input[type="password"]:focus,
						input[type="search"]:focus,
						input[type="number"]:focus,
						input[type="tel"]:focus,
						input[type="range"]:focus,
						input[type="date"]:focus,
						input[type="month"]:focus,
						input[type="week"]:focus,
						input[type="time"]:focus,
						input[type="datetime"]:focus,
						input[type="datetime-local"]:focus,
						input[type="color"]:focus,
						textarea:focus,
						.navigation.pagination .paging-nav-text' =>
						array(
							'color' => '%1$s',
						),
					),
					'rgba_css'    => array(
						'hr'                        => array(
							'background-color' => 'rgba(%1$s, 0.1)',
							'border-color'     => 'rgba(%1$s, 0.1)',
						),
						'input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], input[type="range"], input[type="date"], input[type="month"], input[type="week"], input[type="time"], input[type="datetime"], input[type="datetime-local"], input[type="color"], textarea, .select2-container .select2-choice' => array(
							'color'        => 'rgba(%1$s, 0.5)',
							'border-color' => 'rgba(%1$s, 0.1)',
						),
						'select, fieldset, blockquote, pre, code, abbr, acronym, .hentry table th, .hentry table td' => array(
							'border-color' => 'rgba(%1$s, 0.1)',
						),
						'.hentry table tr:hover td' => array(
							'background-color' => 'rgba(%1$s, 0.05)',
						),
					),
					'editor_css'  => array(
						'.editor-styles-wrapper.edit-post-visual-editor' => array(
							'color' => '%1$s',
						),
					),
				),
				'secondary_text_color'                   => array(
					'label'       => esc_html__( 'Secondary Text', 'primer' ),
					'description' => esc_html__( 'Post bylines, comment counts, post footers and quote footers.', 'primer' ),
					'default'     => '#686868',
					'section'     => 'colors-content',
					'css'         => array(
						'blockquote,
						.entry-meta,
						.entry-footer,
						.comment-meta .says,
						.logged-in-as,
						.wp-block-coblocks-author__heading' =>
						array(
							'color' => '%1$s',
						),
					),
					'editor_css'  => array(
						'.wp-block-quote,
						.wp-block-coblocks-author__heading' =>
						array(
							'color' => '%1$s',
						),
					),
				),
				'footer_widget_heading_text_color'       => array(
					'label'           => esc_html__( 'Widget Heading Text', 'primer' ),
					'default'         => '#353535',
					'section'         => 'colors-footer',
					'active_callback' => 'primer_has_active_footer_sidebars',
					'css'             => array(
						'.site-footer .widget-title,
						.site-footer h1,
						.site-footer h2,
						.site-footer h3,
						.site-footer h4,
						.site-footer h5,
						.site-footer h6' =>
						array(
							'color' => '%1$s',
						),
					),
				),
				'footer_widget_text_color'               => array(
					'label'           => esc_html__( 'Widget Text', 'primer' ),
					'default'         => '#252525',
					'section'         => 'colors-footer',
					'active_callback' => 'primer_has_active_footer_sidebars',
					'css'             => array(
						'.site-footer .widget,
						.site-footer .widget form label' =>
						array(
							'color' => '%1$s',
						),
					),
				),
				'footer_menu_text_color'                 => array(
					'label'           => esc_html__( 'Menu Text', 'primer' ),
					'default'         => '#686868',
					'section'         => 'colors-footer',
					'priority'        => 20,
					'active_callback' => 'primer_has_footer_menu',
					'css'             => array(
						'.footer-menu ul li a,
						.footer-menu ul li a:visited' =>
						array(
							'color' => '%1$s',
						),
						'.site-info-wrapper .social-menu a' => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css'        => array(
						'.footer-menu ul li a:hover,
						.footer-menu ul li a:visited:hover' =>
						array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
				),
				'footer_text_color'                      => array(
					'label'    => esc_html__( 'Copyright Text', 'primer' ),
					'default'  => '#686868',
					'section'  => 'colors-footer',
					'priority' => 30,
					'css'      => array(
						'.site-info-wrapper .site-info-text' => array(
							'color' => '%1$s',
						),
					),
				),
				/**
				 * Link / Button colors
				 */
				'link_color'                             => array(
					'label'           => esc_html__( 'Link Text', 'primer' ),
					'default'         => '#ff6663',
					'section'         => 'colors-content',
					'css'             => array(
						'a, a:visited,
						.entry-title a:hover, .entry-title a:visited:hover' =>
						array(
							'color' => '%1$s',
						),
						'.navigation.pagination .nav-links .page-numbers.current, .social-menu a:hover' => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css'        => array(
						'a:hover, a:visited:hover, a:focus, a:visited:focus, a:active, a:visited:active' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
						'.comment-list li.bypostauthor' => array(
							'border-color' => 'rgba(%1$s, 0.2)',
						),
					),
					'editor_css'      => array(
						'.editor-styles-wrapper a' => array(
							'color' => '%1$s',
						),
					),
					'editor_rgba_css' => array(
						'a:not(.editor-format-toolbar__link-container-value):hover' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
				),
				'button_color'                           => array(
					'label'      => esc_html__( 'Background', 'primer' ),
					'default'    => '#ff6663',
					'section'    => 'colors-buttons',
					'css'        => array(
						'button,
						a.button, a.button:visited,
						input[type="button"],
						input[type="reset"],
						input[type="submit"],
						.wp-block-button__link,
						.site-info-wrapper .social-menu a:hover' =>
						array(
							'background-color' => '%1$s',
							'border-color'     => '%1$s',
						),
					),
					'rgba_css'   => array(
						'button:hover, button:active, button:focus,
						a.button:hover, a.button:active, a.button:focus, a.button:visited:hover, a.button:visited:active, a.button:visited:focus,
						input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus,
						input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus,
						input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus' =>
						array(
							'background-color' => 'rgba(%1$s, 0.8)',
							'border-color'     => 'rgba(%1$s, 0.8)',
						),
					),
					'editor_css' => array(
						'.wp-block-button__link' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'button_text_color'                      => array(
					'label'      => esc_html__( 'Text', 'primer' ),
					'default'    => '#ffffff',
					'section'    => 'colors-buttons',
					'css'        => array(
						'button, button:hover, button:active, button:focus,
						a.button, a.button:hover, a.button:active, a.button:focus, a.button:visited, a.button:visited:hover, a.button:visited:active, a.button:visited:focus,
						input[type="button"], input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus,
						input[type="reset"], input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus,
						input[type="submit"], input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus,
						.wp-block-button__link' =>
						array(
							'color' => '%1$s',
						),
					),
					'editor_css' => array(
						'.wp-block-button__link' => array(
							'color' => '%1$s',
						),
					),
				),
				/**
				 * Background colors
				 */
				'background_color'                       => array(
					'label'   => esc_html__( 'Page Background', 'primer' ),
					'default' => '#f5f5f5',
					'section' => 'colors-content',
					'css'     => array(
						'body' => array(
							'background-color' => '%1$s',
						),
						'.navigation.pagination .nav-links .page-numbers.current' => array(
							'color' => '%1$s',
						),
					),
				),
				'content_background_color'               => array(
					'label'      => esc_html__( 'Content Background', 'primer' ),
					'default'    => '#ffffff',
					'section'    => 'colors-content',
					'css'        => array(
						'.hentry, .comments-area, .widget, #page > .page-title-container' => array(
							'background-color' => '%1$s',
						),
					),
					'editor_css' => array(
						'.block-editor__container' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'hero_background_color'                  => array(
					'label'    => esc_html__( 'Hero Background', 'primer' ),
					'default'  => '#0b3954',
					'section'  => 'colors-header',
					'priority' => 20,
					'css'      => array(
						primer_get_hero_image_selector() => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css' => array(
						primer_get_hero_image_selector() => array(
							'-webkit-box-shadow' => 'inset 0 0 0 9999em',
							'-moz-box-shadow'    => 'inset 0 0 0 9999em',
							'box-shadow'         => 'inset 0 0 0 9999em',
							'color'              => sprintf( 'rgba(%%1$s, %s)', $this->get_color_overlay_transparency_value() ),
						),
					),
				),
				'menu_background_color'                  => array(
					'label'   => esc_html__( 'Background', 'primer' ),
					'default' => '#0b3954',
					'section' => 'colors-menu',
					'css'     => array(
						'.main-navigation-container, .main-navigation.open, .main-navigation ul ul, .main-navigation .sub-menu' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'footer_widget_background_color'         => array(
					'label'           => esc_html__( 'Widgets Background', 'primer' ),
					'default'         => '#0b3954',
					'section'         => 'colors-footer',
					'active_callback' => 'primer_has_active_footer_sidebars',
					'css'             => array(
						'.site-footer' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'footer_widget_content_background_color' => array(
					'label'           => esc_html__( 'Widget Content Background', 'primer' ),
					'default'         => '#ffffff',
					'section'         => 'colors-footer',
					'active_callback' => 'primer_has_active_footer_sidebars',
					'css'             => array(
						'.site-footer .widget' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'footer_background_color'                => array(
					'label'    => esc_html__( 'Footer Background', 'primer' ),
					'default'  => '#f5f5f5',
					'section'  => 'colors-footer',
					'priority' => 30,
					'css'      => array(
						'.site-info-wrapper' => array(
							'background-color' => '%1$s',
						),
						'.site-info-wrapper .social-menu a,
						.site-info-wrapper .social-menu a:visited,
						.site-info-wrapper .social-menu a:hover,
						.site-info-wrapper .social-menu a:visited:hover' =>
						array(
							'color' => '%1$s',
						),
					),
				),
				/**
				 * Editor color palette colors
				 */
				'primary_color'                          => array(
					'label'   => esc_html__( 'Primary', 'primer' ),
					'default' => '#03263B',
					'section' => 'colors-palette',
					'css'     => array(
						'.has-primary-color'            => array(
							'color' => '%1$s',
						),
						'.has-primary-background-color' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'secondary_color'                        => array(
					'label'   => esc_html__( 'Secondary', 'primer' ),
					'default' => '#0b3954',
					'section' => 'colors-palette',
					'css'     => array(
						'.has-secondary-color'            => array(
							'color' => '%1$s',
						),
						'.has-secondary-background-color' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'tertiary_color'                         => array(
					'label'   => esc_html__( 'Tertiary', 'primer' ),
					'default' => '#bddae6',
					'section' => 'colors-palette',
					'css'     => array(
						'.has-tertiary-color'            => array(
							'color' => '%1$s',
						),
						'.has-tertiary-background-color' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'quaternary_color'                       => array(
					'label'   => esc_html__( 'Quaternary', 'primer' ),
					'default' => '#ff6663',
					'section' => 'colors-palette',
					'css'     => array(
						'.has-quaternary-color'            => array(
							'color' => '%1$s',
						),
						'.has-quaternary-background-color' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'quinary_color'                          => array(
					'label'   => esc_html__( 'Quinary', 'primer' ),
					'default' => '#ffffff',
					'section' => 'colors-palette',
					'css'     => array(
						'.has-quinary-color'            => array(
							'color' => '%1$s',
						),
						'.has-quinary-background-color' => array(
							'background-color' => '%1$s',
						),
					),
				),
			)
		);

		if ( ! $this->colors ) {

			return;

		}

		/**
		 * Custom color scheme stub.
		 *
		 * The `_custom` color scheme key is used only when the user
		 * diverges from a predefined scheme. This stub is required
		 * and not filterable.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$custom_scheme = array(
			'_custom' => array(
				'label' => sprintf( '- %s -', esc_html__( 'Custom', 'primer' ) ),
			),
		);

		/**
		 * Default color scheme.
		 *
		 * The `default` color scheme is required and not filterable.
		 * If you want to customize values in this scheme, do so via
		 * a `primer_colors` filter in your Child Theme.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$default_scheme = array(
			'default' => array(
				'label'      => esc_html__( 'Default', 'primer' ),
				'colors'     => array_combine(
					array_keys( $this->colors ),
					wp_list_pluck( $this->colors, 'default' )
				),
				'primary'    => sanitize_hex_color( '#' . get_theme_mod( 'primary_color', '03263B' ) ),
				'secondary'  => sanitize_hex_color( '#' . get_theme_mod( 'secondary_color', '0b3954' ) ),
				'tertiary'   => sanitize_hex_color( '#' . get_theme_mod( 'tertiary_color', 'bddae6' ) ),
				'quaternary' => sanitize_hex_color( '#' . get_theme_mod( 'quaternary_color', 'ff6663' ) ),
				'quinary'    => sanitize_hex_color( '#' . get_theme_mod( 'quinary_color', 'ffffff' ) ),
			),
		);

		$color_schemes = array(
			'blush'     => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Blush', 'primer' ),
				'base'       => '#cc494f',
				'primary'    => '#AE282F',
				'secondary'  => '#cc494f',
				'tertiary'   => '#EF767C',
				'quaternary' => '#FCA6AB',
				'quinary'    => '#ffffff',
			),
			'bronze'    => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Bronze', 'primer' ),
				'base'       => '#b1a18b',
				'primary'    => '#60523F',
				'secondary'  => '#907E66',
				'tertiary'   => '#B1A18B',
				'quaternary' => '#E0D2C0',
				'quinary'    => '#ffffff',
			),
			'canary'    => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Canary', 'primer' ),
				'base'       => '#e9c46a',
				'primary'    => '#C69E40',
				'secondary'  => '#E9C46A',
				'tertiary'   => '#FFE19A',
				'quaternary' => '#FFEDC3',
				'quinary'    => '#ffffff',
			),
			'cool'      => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Cool', 'primer' ),
				'base'       => '#78c3fb',
				'primary'    => '#51AFF7',
				'secondary'  => '#78C2FB',
				'tertiary'   => '#A4D6FD',
				'quaternary' => '#DFF1FF',
				'quinary'    => '#ffffff',
			),
			'dark'      => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Dark', 'primer' ),
				'base'       => '#222222',
				'primary'    => '#222222',
				'secondary'  => '#282828',
				'tertiary'   => '#626262',
				'quaternary' => '#969595',
				'quinary'    => '#ffffff',
			),
			'iguana'    => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Iguana', 'primer' ),
				'base'       => '#62bf7c',
				'primary'    => '#218D3E',
				'secondary'  => '#62bf7c',
				'tertiary'   => '#8FD8A2',
				'quaternary' => '#C1EDCC',
				'quinary'    => '#ffffff',
			),
			'muted'     => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Muted', 'primer' ),
				'base'       => '#3e4c75',
				'primary'    => '#42495E',
				'secondary'  => '#5a6175',
				'tertiary'   => '#777D8D',
				'quaternary' => '#9EA1AC',
				'quinary'    => '#ffffff',
			),
			'plum'      => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Plum', 'primer' ),
				'base'       => '#5d5179',
				'primary'    => '#463A62',
				'secondary'  => '#5D5179',
				'tertiary'   => '#7A7091',
				'quaternary' => '#9F98AF',
				'quinary'    => '#ffffff',
			),
			'rose'      => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Rose', 'primer' ),
				'base'       => '#f49390',
				'primary'    => '#CC5B58',
				'secondary'  => '#f49390',
				'tertiary'   => '#FFBDBC',
				'quaternary' => '#FFDEDD',
				'quinary'    => '#ffffff',
			),
			'tangerine' => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Tangerine', 'primer' ),
				'base'       => '#fc9e4f',
				'primary'    => '#EA7F27',
				'secondary'  => '#fc9e4f',
				'tertiary'   => '#FFB272',
				'quaternary' => '#FFCA9E',
				'quinary'    => '#ffffff',
			),
			'turquoise' => array(
				'label'      => /* translators: color scheme name */ esc_html__( 'Turquoise', 'primer' ),
				'base'       => '#48e5c2',
				'primary'    => '#00c7a9',
				'secondary'  => '#48e5c2',
				'tertiary'   => '#A5F7E5',
				'quaternary' => '#d4f7ef',
				'quinary'    => '#ffffff',
			),
		);

		/**
		 * Use default colors as starting point for every scheme.
		 */
		foreach ( $color_schemes as &$args ) {

			$args['colors'] = $default_scheme['default']['colors'];

		}

		if ( is_custom_primer_child() ) {

			$overrides = array(
				'blush'     => array(
					'colors' => array(
						'link_color'                     => $color_schemes['blush']['base'],
						'button_color'                   => $color_schemes['blush']['base'],
						'hero_background_color'          => $color_schemes['blush']['base'],
						'menu_background_color'          => $color_schemes['blush']['base'],
						'footer_widget_background_color' => $color_schemes['blush']['base'],
						// Color palette.
						'primary_color'                  => $color_schemes['blush']['primary'],
						'secondary_color'                => $color_schemes['blush']['secondary'],
						'tertiary_color'                 => $color_schemes['blush']['tertiary'],
						'quaternary_color'               => $color_schemes['blush']['quaternary'],
						'quinary_color'                  => $color_schemes['blush']['quinary'],

					),
				),
				'bronze'    => array(
					'colors' => array(
						'link_color'                     => $color_schemes['bronze']['base'],
						'button_color'                   => $color_schemes['bronze']['base'],
						'hero_background_color'          => $color_schemes['bronze']['base'],
						'menu_background_color'          => $color_schemes['bronze']['base'],
						'footer_widget_background_color' => $color_schemes['bronze']['base'],
						// Color palette.
						'primary_color'                  => $color_schemes['bronze']['primary'],
						'secondary_color'                => $color_schemes['bronze']['secondary'],
						'tertiary_color'                 => $color_schemes['bronze']['tertiary'],
						'quaternary_color'               => $color_schemes['bronze']['quaternary'],
						'quinary_color'                  => $color_schemes['bronze']['quinary'],
					),
				),
				'canary'    => array(
					'colors' => array(
						'link_color'                     => $color_schemes['canary']['base'],
						'button_color'                   => $color_schemes['canary']['base'],
						'hero_background_color'          => $color_schemes['canary']['base'],
						'menu_background_color'          => $color_schemes['canary']['base'],
						'footer_widget_background_color' => $color_schemes['canary']['base'],
						// Color palette.
						'primary_color'                  => $color_schemes['canary']['primary'],
						'secondary_color'                => $color_schemes['canary']['secondary'],
						'tertiary_color'                 => $color_schemes['canary']['tertiary'],
						'quaternary_color'               => $color_schemes['canary']['quaternary'],
						'quinary_color'                  => $color_schemes['canary']['quinary'],
					),
				),
				'cool'      => array(
					'colors' => array(
						'link_color'                     => $color_schemes['cool']['base'],
						'button_color'                   => $color_schemes['cool']['base'],
						'hero_background_color'          => $color_schemes['cool']['base'],
						'menu_background_color'          => $color_schemes['cool']['base'],
						'footer_widget_background_color' => $color_schemes['cool']['base'],
						// Color palette.
						'primary_color'                  => $color_schemes['cool']['primary'],
						'secondary_color'                => $color_schemes['cool']['secondary'],
						'tertiary_color'                 => $color_schemes['cool']['tertiary'],
						'quaternary_color'               => $color_schemes['cool']['quaternary'],
						'quinary_color'                  => $color_schemes['cool']['quinary'],
					),
				),
				'dark'      => array(
					'colors' => array(
						// Text.
						'tagline_text_color'               => '#999999',
						'heading_text_color'               => '#ffffff',
						'primary_text_color'               => '#e5e5e5',
						'secondary_text_color'             => '#c1c1c1',
						'footer_widget_heading_text_color' => '#ffffff',
						'footer_widget_text_color'         => '#ffffff',
						// Backgrounds.
						'background_color'                 => '#222222',
						'content_background_color'         => '#333333',
						'hero_background_color'            => '#282828',
						'menu_background_color'            => '#333333',
						'footer_widget_content_background_color' => '#333333',
						'footer_widget_background_color'   => '#282828',
						'footer_background_color'          => '#222222',
						// Color palette.
						'primary_color'                    => $color_schemes['dark']['primary'],
						'secondary_color'                  => $color_schemes['dark']['secondary'],
						'tertiary_color'                   => $color_schemes['dark']['tertiary'],
						'quaternary_color'                 => $color_schemes['dark']['quaternary'],
						'quinary_color'                    => $color_schemes['dark']['quinary'],
					),
				),
				'iguana'    => array(
					'colors' => array(
						'link_color'                     => $color_schemes['iguana']['base'],
						'button_color'                   => $color_schemes['iguana']['base'],
						'hero_background_color'          => $color_schemes['iguana']['base'],
						'menu_background_color'          => $color_schemes['iguana']['base'],
						'footer_widget_background_color' => $color_schemes['iguana']['base'],
						// Color palette.
						'primary_color'                  => $color_schemes['iguana']['primary'],
						'secondary_color'                => $color_schemes['iguana']['secondary'],
						'tertiary_color'                 => $color_schemes['iguana']['tertiary'],
						'quaternary_color'               => $color_schemes['iguana']['quaternary'],
						'quinary_color'                  => $color_schemes['iguana']['quinary'],
					),
				),
				'muted'     => array(
					'colors' => array(
						// Text.
						'heading_text_color'               => '#4f5875',
						'primary_text_color'               => '#4f5875',
						'secondary_text_color'             => '#888c99',
						'footer_widget_heading_text_color' => '#4f5875',
						'footer_widget_text_color'         => '#4f5875',
						'footer_menu_text_color'           => $color_schemes['muted']['base'],
						'footer_text_color'                => '#4f5875',
						// Links & Buttons.
						'link_color'                       => $color_schemes['muted']['base'],
						'button_color'                     => $color_schemes['muted']['base'],
						// Backgrounds.
						'background_color'                 => '#d5d6e0',
						'hero_background_color'            => '#5a6175',
						'menu_background_color'            => '#5a6175',
						'footer_widget_background_color'   => '#5a6175',
						'footer_background_color'          => '#d5d6e0',
						// Color palette.
						'primary_color'                    => $color_schemes['muted']['primary'],
						'secondary_color'                  => $color_schemes['muted']['secondary'],
						'tertiary_color'                   => $color_schemes['muted']['tertiary'],
						'quaternary_color'                 => $color_schemes['muted']['quaternary'],
						'quinary_color'                    => $color_schemes['muted']['quinary'],
					),
				),
				'plum'      => array(
					'colors' => array(
						'link_color'                     => $color_schemes['plum']['base'],
						'button_color'                   => $color_schemes['plum']['base'],
						'hero_background_color'          => $color_schemes['plum']['base'],
						'menu_background_color'          => $color_schemes['plum']['base'],
						'footer_widget_background_color' => $color_schemes['plum']['base'],
						// Color palette.
						'primary_color'                  => $color_schemes['plum']['primary'],
						'secondary_color'                => $color_schemes['plum']['secondary'],
						'tertiary_color'                 => $color_schemes['plum']['tertiary'],
						'quaternary_color'               => $color_schemes['plum']['quaternary'],
						'quinary_color'                  => $color_schemes['plum']['quinary'],
					),
				),
				'rose'      => array(
					'colors' => array(
						'link_color'                     => $color_schemes['rose']['base'],
						'button_color'                   => $color_schemes['rose']['base'],
						'hero_background_color'          => $color_schemes['rose']['base'],
						'menu_background_color'          => $color_schemes['rose']['base'],
						'footer_widget_background_color' => $color_schemes['rose']['base'],
						// Color palette.
						'primary_color'                  => $color_schemes['rose']['primary'],
						'secondary_color'                => $color_schemes['rose']['secondary'],
						'tertiary_color'                 => $color_schemes['rose']['tertiary'],
						'quaternary_color'               => $color_schemes['rose']['quaternary'],
						'quinary_color'                  => $color_schemes['rose']['quinary'],
					),
				),
				'tangerine' => array(
					'colors' => array(
						'link_color'                     => $color_schemes['tangerine']['base'],
						'button_color'                   => $color_schemes['tangerine']['base'],
						'hero_background_color'          => $color_schemes['tangerine']['base'],
						'menu_background_color'          => $color_schemes['tangerine']['base'],
						'footer_widget_background_color' => $color_schemes['tangerine']['base'],
						// Color palette.
						'primary_color'                  => $color_schemes['tangerine']['primary'],
						'secondary_color'                => $color_schemes['tangerine']['secondary'],
						'tertiary_color'                 => $color_schemes['tangerine']['tertiary'],
						'quaternary_color'               => $color_schemes['tangerine']['quaternary'],
						'quinary_color'                  => $color_schemes['tangerine']['quinary'],
					),
				),
				'turquoise' => array(
					'colors' => array(
						'link_color'                     => $color_schemes['turquoise']['base'],
						'button_color'                   => $color_schemes['turquoise']['base'],
						'hero_background_color'          => $color_schemes['turquoise']['base'],
						'menu_background_color'          => $color_schemes['turquoise']['base'],
						'footer_widget_background_color' => $color_schemes['turquoise']['base'],
						// Color palette.
						'primary_color'                  => $color_schemes['turquoise']['primary'],
						'secondary_color'                => $color_schemes['turquoise']['secondary'],
						'tertiary_color'                 => $color_schemes['turquoise']['tertiary'],
						'quaternary_color'               => $color_schemes['turquoise']['quaternary'],
						'quinary_color'                  => $color_schemes['turquoise']['quinary'],
					),
				),
			);

			$color_schemes = primer_array_replace_recursive( $color_schemes, $overrides );

		} // End if().

		/**
		 * Filter the available color schemes.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$color_schemes = (array) apply_filters( 'primer_color_schemes', $color_schemes );

		// Remove any invalid color schemes.
		$color_schemes = array_filter(
			$color_schemes,
			array( $this, 'is_valid_color_scheme_array' )
		);

		ksort( $color_schemes );

		$this->color_schemes = $custom_scheme + $default_scheme + $color_schemes;

		add_action( 'customize_register', array( $this, 'colors' ) );
		add_action( 'customize_register', array( $this, 'color_scheme' ) );
		add_action( 'customize_register', array( $this, 'color_overlay_transparency' ) );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'colors_control_js' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'colors_preview_css' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_colors_inline_css' ), 11 );

		add_action( 'after_setup_theme', array( $this, 'header' ) );
		add_action( 'after_setup_theme', array( $this, 'background' ) );
		add_action( 'after_setup_theme', array( $this, 'block_editor_color_palette' ) );

		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_colors_inline_css' ), 1 );
	}

	/**
	 * Custom colors for use in the editor.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/reference/theme-support/
	 */
	public function block_editor_color_palette() {

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Primary', 'primer' ),
					'slug'  => 'primary',
					'color' => $this->color_schemes[ $this->get_current_color_scheme() ]['primary'],
				),
				array(
					'name'  => esc_html__( 'Secondary', 'primer' ),
					'slug'  => 'secondary',
					'color' => $this->color_schemes[ $this->get_current_color_scheme() ]['secondary'],
				),
				array(
					'name'  => esc_html__( 'Tertiary', 'primer' ),
					'slug'  => 'tertiary',
					'color' => $this->color_schemes[ $this->get_current_color_scheme() ]['tertiary'],
				),
				array(
					'name'  => esc_html__( 'Quaternary', 'primer' ),
					'slug'  => 'quaternary',
					'color' => $this->color_schemes[ $this->get_current_color_scheme() ]['quaternary'],
				),
				array(
					'name'  => esc_html__( 'Quinary', 'primer' ),
					'slug'  => 'quinary',
					'color' => $this->color_schemes[ $this->get_current_color_scheme() ]['quinary'],
				),
			)
		);
	}

	/**
	 * Register color panel, sections, controls, and settings.
	 *
	 * @action customize_register
	 * @see    WP_Customize_Manager
	 *
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Instance of the WP_Customize_Manager class.
	 */
	public function colors( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_panel(
			'colors',
			array(
				'title'       => esc_html__( 'Colors', 'primer' ),
				'description' => esc_html__( 'Get what you need.', 'primer' ),
				'priority'    => 40,
			)
		);

		$wp_customize->add_section(
			'colors-scheme',
			array(
				'title' => esc_html__( 'Color Schemes', 'primer' ),
				'panel' => 'colors',
			)
		);

		// Utilize the new color palette panel if the block editor exists.
		if ( function_exists( 'register_block_type' ) ) {
			$wp_customize->add_section(
				'colors-palette',
				array(
					'title'       => esc_html__( 'Color Palette', 'primer' ),
					'description' => esc_html__( 'The color palette, based on the selected color scheme, is used to style content within the block editor.', 'primer' ),
					'panel'       => 'colors',
				)
			);
		}

		$wp_customize->add_section(
			'colors-header',
			array(
				'title' => esc_html__( 'Header', 'primer' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_section(
			'colors-menu',
			array(
				'title' => esc_html__( 'Menu', 'primer' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_section(
			'colors-buttons',
			array(
				'title' => esc_html__( 'Buttons', 'primer' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_section(
			'colors-content',
			array(
				'title' => esc_html__( 'Content', 'primer' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_section(
			'colors-footer',
			array(
				'title' => esc_html__( 'Footer', 'primer' ),
				'panel' => 'colors',
			)
		);

		foreach ( $this->colors as $name => $args ) {

			$this->register_color_setting( $wp_customize, $name, $args );

		}

	}

	/**
	 * Register a custom color setting.
	 *
	 * @since 1.0.0
	 * @see   $this->colors()
	 * @see   WP_Customize_Manager
	 *
	 * @param WP_Customize_Manager $wp_customize Instance of the WP_Customize_Manager class.
	 * @param string               $name Color key name.
	 * @param array                $args Color args.
	 */
	public function register_color_setting( WP_Customize_Manager $wp_customize, $name, array $args ) {

		if ( empty( $name ) || empty( $args['default'] ) ) {

			return;

		}

		$name = sanitize_key( $name );

		$wp_customize->add_setting(
			$name,
			array(
				'default'              => sanitize_hex_color_no_hash( $args['default'] ),
				'sanitize_callback'    => ( 'header_textcolor' === $name ) ? array( $wp_customize, '_sanitize_header_textcolor' ) : 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$name,
				array(
					'label'           => ! empty( $args['label'] ) ? $args['label'] : $name,
					'description'     => ! empty( $args['description'] ) ? $args['description'] : null,
					'section'         => ! empty( $args['section'] ) ? $args['section'] : 'colors-content',
					'priority'        => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
					'active_callback' => ! empty( $args['active_callback'] ) ? $args['active_callback'] : null,
				)
			)
		);

	}

	/**
	 * Enqueue inline CSS in the block editor for custom colors.
	 *
	 * @action enqueue_block_editor_assets
	 * @since  1.8.7
	 */
	public function enqueue_block_editor_colors_inline_css() {

		// Register Customizer styles within the editor to use for inline additions.
		wp_register_style( Primer_Customizer::$stylesheet . '-editor-customizer', false, PRIMER_VERSION, 'all' );

		// Enqueue the Customizer style.
		wp_enqueue_style( Primer_Customizer::$stylesheet . '-editor-customizer' );

		foreach ( $this->colors as $name => $args ) {

			if ( empty( $name ) || empty( $args['editor_css'] ) ) {

				continue;

			}

			$default = $this->get_default_color( $name, 'default' );
			$hex     = trim( get_theme_mod( $name, $default ), '#' );
			$css     = sprintf( Primer_Customizer::parse_css_rules( $args['editor_css'] ), '#' . $hex );

			if ( ! empty( $args['editor_rgba_css'] ) ) {

				$css .= sprintf(
					Primer_Customizer::parse_css_rules( $args['editor_rgba_css'] ),
					implode( ', ', primer_hex2rgb( $hex ) )
				);

			}

			wp_add_inline_style( Primer_Customizer::$stylesheet . '-editor-customizer', $css );

		}
	}

	/**
	 * Enqueue inline CSS for custom colors.
	 *
	 * @action wp_enqueue_scripts
	 * @since  1.0.0
	 */
	public function enqueue_colors_inline_css() {

		foreach ( $this->colors as $name => $args ) {

			$this->add_color_inline_css( $name, $args );

		}

	}

	/**
	 * Add color inline CSS.
	 *
	 * @see   $this->enqueue_colors_inline_css()
	 * @since 1.0.0
	 *
	 * @param string $name Color key name.
	 * @param array  $args Color args.
	 */
	public function add_color_inline_css( $name, array $args ) {

		if ( empty( $name ) || empty( $args['css'] ) ) {

			return;

		}

		$default = $this->get_default_color( $name, 'default' );
		$hex     = trim( get_theme_mod( $name, $default ), '#' );
		$css     = sprintf( Primer_Customizer::parse_css_rules( $args['css'] ), '#' . $hex );

		if ( ! empty( $args['rgba_css'] ) ) {

			$css .= sprintf(
				Primer_Customizer::parse_css_rules( $args['rgba_css'] ),
				implode( ', ', primer_hex2rgb( $hex ) )
			);

		}

		wp_add_inline_style( Primer_Customizer::$stylesheet, $css );

	}

	/**
	 * Return the default HEX value for a color in a scheme.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $color  Color key name.
	 * @param  string $scheme (optional) Color scheme name. Default is an empty string.
	 * @param  bool   $hash   (optional) Whether to prepend color value output a `#` symbol. Default is `false`.
	 *
	 * @return string|null
	 */
	public function get_default_color( $color, $scheme = '', $hash = false ) {

		/**
		 * Load for backwards compatibility prior to WordPress 4.6.
		 *
		 * @link  https://core.trac.wordpress.org/ticket/27583
		 * @since 1.0.0
		 */
		if ( ! function_exists( 'sanitize_hex_color' ) || ! function_exists( 'sanitize_hex_color_no_hash' ) ) {

			require_once ABSPATH . 'wp-includes/class-wp-customize-manager.php';

		}

		$scheme = empty( $scheme ) ? $this->get_current_color_scheme_array() : $this->color_schemes[ $this->sanitize_color_scheme( $scheme ) ];
		$hex    = isset( $scheme['colors'][ $color ] ) ? trim( $scheme['colors'][ $color ], '#' ) : null;

		return ( $hash ) ? sanitize_hex_color( '#' . $hex ) : sanitize_hex_color_no_hash( $hex );

	}

	/**
	 * Return an array of CSS rules for a color.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $color Color key name.
	 *
	 * @return array
	 */
	public function get_color_css( $color ) {

		return ! empty( $this->colors[ $color ]['css'] ) ? $this->colors[ $color ]['css'] : array();

	}

	/**
	 * Return an array of CSS for colors supporting RGBA.
	 *
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function get_rgba_css() {

		$colors = array();

		foreach ( $this->colors as $name => $args ) {

			if ( ! empty( $name ) && ! empty( $args['rgba_css'] ) && is_array( $args['rgba_css'] ) ) {

				$colors[ $name ] = $args['rgba_css'];

			}
		}

		return $colors;

	}

	/**
	 * Register a color scheme setting.
	 *
	 * @action customize_register
	 * @see    WP_Customize_Manager
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Instance of the WP_Customize_Manager class.
	 */
	public function color_scheme( WP_Customize_Manager $wp_customize ) {

		if ( count( $this->color_schemes ) < 2 ) {

			return;

		}

		$wp_customize->add_setting(
			'color_scheme',
			array(
				'default'           => 'default',
				'sanitize_callback' => array( $this, 'sanitize_color_scheme' ),
				'transport'         => 'postMessage',
			)
		);

		$choices = array_combine(
			array_keys( $this->color_schemes ),
			wp_list_pluck( $this->color_schemes, 'label' )
		);

		$wp_customize->add_control(
			'color_scheme',
			array(
				'label'    => esc_html__( 'Base Color Scheme', 'primer' ),
				'section'  => 'colors-scheme',
				'type'     => 'select',
				'choices'  => $choices,
				'priority' => 1,
			)
		);

	}

	/**
	 * Enqueue color scheme control in the Customizer.
	 *
	 * @action customize_controls_enqueue_scripts
	 * @since  1.0.0
	 */
	public function colors_control_js() {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'primer-colors-control', get_template_directory_uri() . "/assets/js/admin/colors-control{$suffix}.js", array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), PRIMER_VERSION, true );

		wp_localize_script( 'primer-colors-control', 'colorSchemes', $this->color_schemes );

	}

	/**
	 * Inline style for color scheme.
	 *
	 * @action customize_controls_print_footer_scripts
	 * @since  1.0.0
	 */
	public function colors_preview_css() {

		?>
		<script type="text/html" id="tmpl-primer-colors-css">
		<?php

		foreach ( $this->colors as $name => $args ) {

			if ( empty( $name ) || empty( $args['css'] ) || ! is_array( $args['css'] ) ) {

				continue;

			}

			printf( // xss ok.
				Primer_Customizer::parse_css_rules( $args['css'] ),
				sprintf( '{{ data.%s }}', $name )
			);

		}
		?>
		</script>
		<?php

		$rgba_colors = $this->get_rgba_css();

		if ( ! $rgba_colors ) {

			// Required for themes without RGBA CSS rules.
			echo '<script type="text/html" id="tmpl-primer-colors-css-rgba"></script>';

		}

		?>
		<script type="text/html" id="tmpl-primer-colors-css-rgba">
		<?php

		foreach ( $rgba_colors as $name => $css ) {

			printf( // xss ok.
				Primer_Customizer::parse_css_rules( $css ),
				sprintf( '{{ data.%s }}', $name )
			);

		}

		?>
		</script>
		<?php

	}

	/**
	 * Check if a color scheme exists.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $scheme Color scheme slug name.
	 *
	 * @return bool
	 */
	public function color_scheme_exists( $scheme ) {

		return array_key_exists( $scheme, $this->color_schemes );

	}

	/**
	 * Check if a color scheme array is valid.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $scheme Color scheme array.
	 *
	 * @return bool
	 */
	public function is_valid_color_scheme_array( array $scheme ) {

		return (
			! empty( $scheme['label'] )
			&&
			! empty( $scheme['colors'] )
			&&
			is_array( $scheme['colors'] )
		);

	}

	/**
	 * Sanitize a color scheme by ensuring it exists and is valid.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $scheme Color scheme slug name.
	 *
	 * @return string
	 */
	public function sanitize_color_scheme( $scheme ) {

		return ( $this->color_scheme_exists( $scheme ) && $this->is_valid_color_scheme_array( $this->color_schemes[ $scheme ] ) ) ? $scheme : 'default';

	}

	/**
	 * Return the current color scheme name.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_current_color_scheme() {

		return $this->sanitize_color_scheme( get_theme_mod( 'color_scheme', 'default' ) );

	}

	/**
	 * Return the current color scheme array.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_current_color_scheme_array() {

		return $this->color_schemes[ $this->get_current_color_scheme() ];

	}

	/**
	 * Add custom header support.
	 *
	 * @action after_setup_theme
	 * @since  1.0.0
	 * @uses   $this->header_css()
	 */
	public function header() {

		/**
		 * Filter the custom header args.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$args = (array) apply_filters(
			'primer_custom_header_args',
			array(
				'default-text-color' => $this->get_default_color( 'header_textcolor', 'default' ),
				'width'              => 2400,
				'height'             => 1300,
				'flex-height'        => true,
				'wp-head-callback'   => array( $this, 'header_css' ),
				'video'              => true,
			)
		);

		add_theme_support( 'custom-header', $args );

		/**
		 * Filter the default hero images.
		 *
		 * @var array
		 */
		$defaults = (array) apply_filters(
			'primer_default_hero_images',
			array(
				'default' => array(
					'url'           => 'assets/images/hero.jpg',
					'thumbnail_url' => 'assets/images/hero-thumbnail.jpg',
				),
			)
		);

		foreach ( $defaults as $name => &$args ) {

			$path = trailingslashit( get_stylesheet_directory() );
			$url  = trailingslashit( get_stylesheet_directory_uri() );

			if ( ! file_exists( $path . $args['url'] ) ) {

				unset( $defaults[ $name ] );

				continue;

			}

			$args['url']           = $url . $args['url'];
			$args['thumbnail_url'] = file_exists( $path . $args['thumbnail_url'] ) ? $url . $args['thumbnail_url'] : $args['url'];

		}

		if ( $defaults ) {

			register_default_headers( $defaults );

		}

	}

	/**
	 * Custom header CSS.
	 *
	 * @see   $this->header()
	 * @since 1.0.0
	 */
	public function header_css() {

		$color = get_header_textcolor();
		$css   = $this->get_color_css( 'header_textcolor' );

		if ( 'blank' === $color ) {

			$css = array(
				'.site-title, .site-description' => array(
					'position' => 'absolute',
					'clip'     => 'rect(1px, 1px, 1px, 1px)',
				),
			);

		}

		if ( $color && $css ) {

			printf( // xss ok.
				"<style type='text/css'>\n%s\n</style>",
				sprintf( Primer_Customizer::parse_css_rules( $css ), $color )
			);

		}

	}

	/**
	 * Add custom background support.
	 *
	 * @action after_setup_theme
	 * @since  1.0.0
	 */
	public function background() {

		/**
		 * Filter the custom background args.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$args = (array) apply_filters(
			'primer_custom_background_args',
			array(
				'default-color' => $this->get_default_color( 'background_color', 'default' ),
			)
		);

		add_theme_support( 'custom-background', $args );

	}

	/**
	 * Add setting and control for the hero image color overlay transparency.
	 *
	 * @action customize_register
	 * @see    WP_Customize_Manager
	 *
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Instance of the WP_Customize_Manager class.
	 */
	public function color_overlay_transparency( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'hero_image_color_overlay',
			array(
				'default'           => $this->get_color_overlay_transparency_default_value(),
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'hero_image_color_overlay',
			array(
				'label'           => esc_html__( 'Hero Background Overlay', 'primer' ),
				'description'     => esc_html__( 'Control the color overlay transparency when using a custom Header Image.', 'primer' ),
				'section'         => 'colors-header',
				'priority'        => 20,
				'active_callback' => 'primer_has_hero_image',
				'type'            => 'range',
				'input_attrs'     => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
			)
		);

	}

	/**
	 * Return the default hero image color overlay transparency value.
	 *
	 * @since 1.0.0
	 *
	 * @return int Returns the color overlay transparency value.
	 */
	public function get_color_overlay_transparency_default_value() {

		/**
		 * Filter the default hero image color overlay transparency value.
		 *
		 * @since 1.0.0
		 *
		 * @var int
		 */
		return (int) apply_filters( 'primer_hero_image_color_overlay_default', 50 );

	}

	/**
	 * Return the hero image color overlay transparency value.
	 *
	 * @since 1.0.0
	 *
	 * @return string Returns the hero color overlay transparency value.
	 */
	public function get_color_overlay_transparency_value() {

		$default = $this->get_color_overlay_transparency_default_value();

		return sprintf( '%.2f', absint( get_theme_mod( 'hero_image_color_overlay', $default ) ) * 0.01 );

	}

	/**
	 * Magic getter for `$colors` and `$color_schemes` properties.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $name Color key or color scheme slug name.
	 *
	 * @return string Return the specified property within the `Primer_Customizer_Colors` class.
	 */
	public function __get( $name ) {

		if ( ! in_array( $name, array( 'colors', 'color_schemes' ), true ) ) {

			return false;

		}

		return $this->$name;

	}

}

$GLOBALS['primer_customizer_colors'] = new Primer_Customizer_Colors();
