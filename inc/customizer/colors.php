<?php

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
		$this->colors = (array) apply_filters( 'primer_colors',
			array(
				/**
				 * Text colors
				 */
				'header_textcolor' => array(
					'label'   => esc_html__( 'Site Title Text', 'primer' ),
					'default' => '#ffffff',
					'section' => 'colors-header',
					'css'     => array(
						'.site-title a, .site-title a:visited' => array(
							'color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'.site-title a:hover, .site-title a:visited:hover' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
				),
				'tagline_text_color' => array(
					'label'   => esc_html__( 'Tagline Text', 'primer' ),
					'default' => '#ffffff',
					'section' => 'colors-header',
					'css'     => array(
						'.site-description' => array(
							'color' => '%1$s',
						),
					),
				),
				'hero_text_color' => array(
					'label'   => esc_html__( 'Hero Text', 'primer' ),
					'default' => '#ffffff',
					'section' => 'colors-header',
					'css'     => array(
						'.hero,
						.hero .widget h1,
						.hero .widget h2,
						.hero .widget h3,
						.hero .widget h4,
						.hero .widget h5,
						.hero .widget h6,
						.hero .widget p,
						.hero .widget ul,
						.hero .widget ol,
						.hero .widget li,
						.hero .page-header h1' => array(
							'color' => '%1$s',
						),
					),
				),
				'menu_text_color' => array(
					'label'   => esc_html__( 'Text', 'primer' ),
					'default' => '#ffffff',
					'section' => 'colors-menu',
					'css'     => array(
						'.main-navigation ul li a, .main-navigation ul li a:visited, .main-navigation ul li a:hover, .main-navigation ul li a:visited:hover' => array(
							'color' => '%1$s',
						),
						'.main-navigation .sub-menu .menu-item-has-children > a::after' => array(
							'border-right-color' => '%1$s',
							'border-left-color'  => '%1$s', // RTL support
						),
						'.menu-toggle div' => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'.main-navigation ul li a:hover' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
				),
				'heading_text_color' => array(
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
						.widget-title' => array(
							'color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'.entry-title a:hover, .entry-title a:visited:hover, .entry-title a:focus, .entry-title a:visited:focus, .entry-title a:active, .entry-title a:visited:active' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
					),
				),
				'primary_text_color' => array(
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
						.fl-callout-text,
						.fl-rich-text' => array(
							'color' => '%1$s',
						),
						'.social-menu a, .social-menu a:visited' => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'hr' => array(
							'background-color' => 'rgba(%1$s, 0.1)',
						),
						'input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], input[type="range"], input[type="date"], input[type="month"], input[type="week"], input[type="time"], input[type="datetime"], input[type="datetime-local"], input[type="color"], textarea' => array(
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
				),
				'secondary_text_color' => array(
					'label'       => esc_html__( 'Secondary Text', 'primer' ),
					'description' => esc_html__( 'Post bylines, comment counts, comment reply links, post footers and quote footers.', 'primer' ),
					'default'     => '#686868',
					'section'     => 'colors-content',
					'css'         => array(
						'blockquote,
						.entry-meta,
						.entry-footer,
						.comment-meta .says,
						.logged-in-as' => array(
							'color' => '%1$s',
						),
					),
				),
				'footer_widget_text_color' => array(
					'label'    => esc_html__( 'Widget Text', 'primer' ),
					'default'  => '#252525',
					'section'  => 'colors-footer',
					'css'      => array(
						'.site-footer .widget' => array(
							'color' => '%1$s',
						),
					),
				),
				'footer_text_color' => array(
					'label'    => esc_html__( 'Copyright Text', 'primer' ),
					'default'  => '#757575',
					'section'  => 'colors-footer',
					'priority' => 20,
					'css'      => array(
						'.site-info-wrapper .site-info-text' => array(
							'color' => '%1$s',
						),
					),
				),
				/**
				 * Link / Button colors
				 */
				'link_color' => array(
					'label'   => esc_html__( 'Link Text', 'primer' ),
					'default' => '#ff6663',
					'section' => 'colors-content',
					'css'     => array(
						'a, a:visited,
						.entry-title a:hover, .entry-title a:visited:hover' => array(
							'color' => '%1$s',
						),
						'.social-menu a:hover, .social-menu a:visited:hover' => array(
							'background-color' => '%1$s',
						),
					),
					'rgba_css' => array(
						'a:hover, a:visited:hover, a:focus, a:visited:focus, a:active, a:visited:active' => array(
							'color' => 'rgba(%1$s, 0.8)',
						),
						'.comment-list li.bypostauthor' => array(
							'border-color' => 'rgba(%1$s, 0.2)',
						),
					),
				),
				'button_text_color' => array(
					'label'   => esc_html__( 'Text', 'primer' ),
					'default' => '#ffffff',
					'section' => 'colors-buttons',
					'css'     => array(
						'button, button:hover, button:active, button:focus,
						a.button, a.button:hover, a.button:active, a.button:focus, a.button:visited, a.button:visited:hover, a.button:visited:active, a.button:visited:focus,
						a.fl-button, a.fl-button:hover, a.fl-button:active, a.fl-button:focus, a.fl-button:visited, a.fl-button:visited:hover, a.fl-button:visited:active, a.fl-button:visited:focus,
						input[type="button"], input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus,
						input[type="reset"], input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus,
						input[type="submit"], input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus' => array(
							'color' => '%1$s',
						),
					),
				),
				'button_color' => array(
					'label'   => esc_html__( 'Background', 'primer' ),
					'default' => '#ff6663',
					'section' => 'colors-buttons',
					'css'     => array(
						'button,
						a.button, a.button:visited,
						.content-area .fl-builder-content a.fl-button, .content-area .fl-builder-content a.fl-button:visited,
						input[type="button"],
						input[type="reset"],
						input[type="submit"]' => array(
							'background-color' => '%1$s',
							'border-color'     => '%1$s',
						),
					),
					'rgba_css' => array(
						'button:hover, button:active, button:focus,
						a.button:hover, a.button:active, a.button:focus, a.button:visited:hover, a.button:visited:active, a.button:visited:focus,
						.content-area .fl-builder-content a.fl-button:hover, .content-area .fl-builder-content a.fl-button:active, .content-area .fl-builder-content a.fl-button:focus, .content-area .fl-builder-content a.fl-button:visited:hover, .content-area .fl-builder-content a.fl-button:visited:active, .content-area .fl-builder-content a.fl-button:visited:focus,
						input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus,
						input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus,
						input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus' => array(
							'background-color' => 'rgba(%1$s, 0.8)',
							'border-color'     => 'rgba(%1$s, 0.8)',
						),
					),
				),
				/**
				 * Background colors
				 */
				'background_color' => array(
					'label'   => esc_html__( 'Page Background', 'primer' ),
					'default' => '#f5f5f5',
					'section' => 'colors-content',
					'css'     => array(
						'body' => array(
							'background' => '%1$s',
						),
						'.social-menu a, .social-menu a:visited, .social-menu a:hover, .social-menu a:visited:hover' => array(
							'color' => '%1$s',
						),
					),
				),
				'content_background_color' => array(
					'label'   => esc_html__( 'Content Background', 'primer' ),
					'default' => '#ffffff',
					'section' => 'colors-content',
					'css'     => array(
						'.hentry, .widget, #page > .page-title-container' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'hero_background_color' => array(
					'label'   => esc_html__( 'Hero Background', 'primer' ),
					'default' => '#0b3954',
					'section' => 'colors-header',
					'css'     => array(
						primer_get_hero_image_selector() => array(
							'background-color' => '%1$s',
						),
					),
				),
				'menu_background_color' => array(
					'label'   => esc_html__( 'Background', 'primer' ),
					'default' => '#0b3954',
					'section' => 'colors-menu',
					'css'     => array(
						'.main-navigation-container, .main-navigation ul ul, .main-navigation .sub-menu' => array(
							'background-color' => '%1$s',
						),
					),
				),
				'footer_widget_background_color' => array(
					'label'   => esc_html__( 'Widgets Background', 'primer' ),
					'default' => '#0b3954',
					'section' => 'colors-footer',
					'css'     => array(
						'.site-footer' => array(
							'background' => '%1$s',
						),
					),
				),
				'footer_background_color' => array(
					'label'    => esc_html__( 'Copyright Background', 'primer' ),
					'default'  => '#f5f5f5',
					'section'  => 'colors-footer',
					'priority' => 20,
					'css'      => array(
						'.site-info-wrapper' => array(
							'background' => '%1$s',
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
				'label' => sprintf( '- %s -' , esc_html__( 'Custom', 'primer' ) ),
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
				'label'  => esc_html__( 'Default', 'primer' ),
				'colors' => array_combine(
					array_keys( $this->colors ),
					wp_list_pluck( $this->colors, 'default' )
				),
			)
		);

		/**
		 * Filter the available color schemes.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$color_schemes = (array) apply_filters( 'primer_color_schemes',
			array(
				'blush' => array(
					'label'  => esc_html_x( 'Blush Red', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f5f5f5',
						'tagline_text_color'       => '#f5f5f5',
						'hero_text_color'          => '#f5f5f5',
						'menu_text_color'          => '#f5f5f5',
						'heading_text_color'       => '#353535',
						'primary_text_color'       => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#cc494f',
						'button_color'      => '#cc494f',
						'button_text_color' => '#f5f5f5',
						// Backgrounds
						'background_color'               => '#f5f5f5',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#b84247',
						'menu_background_color'          => '#cc494f',
						'footer_widget_background_color' => '#b84247',
						'footer_background_color'        => '#f5f5f5',
					),
				),
				'bronze' => array(
					'label'  => esc_html_x( 'Bronze', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f5f5f5',
						'tagline_text_color'       => '#f5f5f5',
						'hero_text_color'          => '#f5f5f5',
						'menu_text_color'          => '#f5f5f5',
						'heading_text_color'       => '#353535',
						'primary_text_color'       => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#b1a18b',
						'button_color'      => '#b1a18b',
						'button_text_color' => '#f5f5f5',
						// Backgrounds
						'background_color'               => '#f5f5f5',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#a0917d',
						'menu_background_color'          => '#b1a18b',
						'footer_widget_background_color' => '#a0917d',
						'footer_background_color'        => '#f5f5f5',
					),
				),
				'canary' => array(
					'label'  => esc_html_x( 'Canary Yellow', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f5f5f5',
						'tagline_text_color'       => '#f5f5f5',
						'hero_text_color'          => '#f5f5f5',
						'menu_text_color'          => '#f5f5f5',
						'heading_text_color'       => '#353535',
						'primary_text_color'       => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#e9c46a',
						'button_color'      => '#e9c46a',
						'button_text_color' => '#f5f5f5',
						// Backgrounds
						'background_color'               => '#f5f5f5',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#d2b160',
						'menu_background_color'          => '#e9c46a',
						'footer_widget_background_color' => '#d2b160',
						'footer_background_color'        => '#f5f5f5',
					),
				),
				'dark' => array(
					'label'  => esc_html_x( 'Dark', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#e5e5e5',
						'tagline_text_color'       => '#999999',
						'hero_text_color'          => '#e5e5e5',
						'menu_text_color'          => '#e5e5e5',
						'heading_text_color'       => '#e5e5e5',
						'primary_text_color'       => '#e5e5e5',
						'secondary_text_color'     => '#c1c1c1',
						'footer_widget_text_color' => '#e5e5e5',
						'footer_text_color'        => '#e5e5e5',
						// Links & Buttons
						'link_color'        => '#589ef2',
						'button_color'      => '#589ef2',
						'button_text_color' => '#e5e5e5',
						// Backgrounds
						'background_color'               => '#222222',
						'content_background_color'       => '#444444',
						'hero_background_color'          => '#222222',
						'menu_background_color'          => '#333333',
						'footer_widget_background_color' => '#333333',
						'footer_background_color'        => '#222222',
					),
				),
				'iguana' => array(
					'label'  => esc_html_x( 'Iguana Green', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f5f5f5',
						'tagline_text_color'       => '#f5f5f5',
						'hero_text_color'          => '#f5f5f5',
						'menu_text_color'          => '#f5f5f5',
						'heading_text_color'       => '#353535',
						'primary_text_color'       => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#62bf7c',
						'button_color'      => '#62bf7c',
						'button_text_color' => '#f5f5f5',
						// Backgrounds
						'background_color'               => '#f5f5f5',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#58ac70',
						'menu_background_color'          => '#62bf7c',
						'footer_widget_background_color' => '#58ac70',
						'footer_background_color'        => '#f5f5f5',
					),
				),
				'muted' => array(
					'label'  => esc_html_x( 'Muted', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#ffffff',
						'tagline_text_color'       => '#ffffff',
						'hero_text_color'          => '#ffffff',
						'menu_text_color'          => '#ffffff',
						'heading_text_color'       => '#4f5875',
						'primary_text_color'       => '#4f5875',
						'secondary_text_color'     => '#888c99',
						'footer_widget_text_color' => '#4f5875',
						'footer_text_color'        => '#4f5875',
						// Links & Buttons
						'link_color'        => '#3e4c75',
						'button_color'      => '#3e4c75',
						'button_text_color' => '#ffffff',
						// Backgrounds
						'background_color'               => '#d5d6e0',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#5a6175',
						'menu_background_color'          => '#5a6175',
						'footer_widget_background_color' => '#5a6175',
						'footer_background_color'        => '#d5d6e0',
					),
				),
				'plum' => array(
					'label'  => esc_html_x( 'Plum', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f5f5f5',
						'tagline_text_color'       => '#f5f5f5',
						'hero_text_color'          => '#f5f5f5',
						'menu_text_color'          => '#f5f5f5',
						'heading_text_color'       => '#353535',
						'primary_text_color'       => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#5d5179',
						'button_color'      => '#5d5179',
						'button_text_color' => '#f5f5f5',
						// Backgrounds
						'background_color'               => '#f5f5f5',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#54496d',
						'menu_background_color'          => '#5d5179',
						'footer_widget_background_color' => '#54496d',
						'footer_background_color'        => '#f5f5f5',
					),
				),
				'rose' => array(
					'label'  => esc_html_x( 'Rose Pink', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f5f5f5',
						'tagline_text_color'       => '#f5f5f5',
						'hero_text_color'          => '#f5f5f5',
						'menu_text_color'          => '#f5f5f5',
						'heading_text_color'       => '#353535',
						'primary_text_color'       => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#f49390',
						'button_color'      => '#f49390',
						'button_text_color' => '#f5f5f5',
						// Backgrounds
						'background_color'               => '#f5f5f5',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#dc8582',
						'menu_background_color'          => '#f49390',
						'footer_widget_background_color' => '#dc8582',
						'footer_background_color'        => '#f5f5f5',
					),
				),
				'tangerine' => array(
					'label'  => esc_html_x( 'Tangerine', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f5f5f5',
						'tagline_text_color'       => '#f5f5f5',
						'hero_text_color'          => '#f5f5f5',
						'menu_text_color'          => '#f5f5f5',
						'heading_text_color'       => '#353535',
						'primary_text_color'       => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#fc9e4f',
						'button_color'      => '#fc9e4f',
						'button_text_color' => '#f5f5f5',
						// Backgrounds
						'background_color'               => '#f5f5f5',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#e38f47',
						'menu_background_color'          => '#fc9e4f',
						'footer_widget_background_color' => '#e38f47',
						'footer_background_color'        => '#f5f5f5',
					),
				),
				'turquoise' => array(
					'label'  => esc_html_x( 'Turquoise', 'color scheme name', 'primer' ),
					'colors' => array(
						// Text
						'header_textcolor'         => '#f5f5f5',
						'tagline_text_color'       => '#f5f5f5',
						'hero_text_color'          => '#f5f5f5',
						'menu_text_color'          => '#f5f5f5',
						'heading_text_color'       => '#353535',
						'primary_text_color'       => '#252525',
						'secondary_text_color'     => '#686868',
						'footer_widget_text_color' => '#252525',
						'footer_text_color'        => '#686868',
						// Links & Buttons
						'link_color'        => '#48e5c2',
						'button_color'      => '#48e5c2',
						'button_text_color' => '#f5f5f5',
						// Backgrounds
						'background_color'               => '#f5f5f5',
						'content_background_color'       => '#ffffff',
						'hero_background_color'          => '#41cfaf',
						'menu_background_color'          => '#48e5c2',
						'footer_widget_background_color' => '#41cfaf',
						'footer_background_color'        => '#f5f5f5',
					),
				),
			)
		);

		$color_schemes = array_filter(
			$color_schemes,
			array( $this, 'is_valid_color_scheme_array' )
		);

		ksort( $color_schemes );

		$this->color_schemes = $custom_scheme + $default_scheme + $color_schemes;

		add_action( 'customize_register', array( $this, 'colors' ) );
		add_action( 'customize_register', array( $this, 'color_scheme' ) );

		add_action( 'customize_controls_enqueue_scripts',      array( $this, 'color_scheme_control_js' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'color_scheme_preview_css' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_colors_inline_css' ), 11 );

		add_action( 'after_setup_theme', array( $this, 'header' ) );
		add_action( 'after_setup_theme', array( $this, 'background' ) );

	}

	/**
	 * Register color panel, sections, controls, and settings.
	 *
	 * @action customize_register
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function colors( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_panel(
			'colors',
			array(
				'title'       => esc_html__( 'Colors', 'primer' ),
				'description' => 'Get what you need.',
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
	 *
	 * @param WP_Customize_Manager $wp_customize
	 * @param string               $name
	 * @param array                $args
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
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$name,
				array(
					'label'       => ! empty( $args['label'] ) ? $args['label'] : $name,
					'description' => ! empty( $args['description'] ) ? $args['description'] : null,
					'section'     => ! empty( $args['section'] ) ? $args['section'] : 'colors-content',
					'priority'    => ! empty( $args['priority'] ) ? absint( $args['priority'] ) : null,
				)
			)
		);

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
	 * @param string $name
	 * @param array  $args
	 */
	public function add_color_inline_css( $name, array $args ) {

		if ( empty( $name ) || empty( $args['css'] ) ) {

			return;

		}

		$default = $this->get_default_color( $name, 'default' );
		$hex     = trim( get_theme_mod( $name, $default ), '#' );
		$css     = sprintf( Primer_Customizer::parse_css_rules( $args['css'] ), '#' . $hex );

		if ( ! empty( $args['rgba_css'] ) ) {

			$css .= sprintf( Primer_Customizer::parse_css_rules( $args['rgba_css'] ), implode( ', ', primer_hex2rgb( $hex ) ) );

		}

		wp_add_inline_style( 'primer', $css );

	}

	/**
	 * Return the default HEX value for a color in a scheme.
	 *
	 * @param  string $color
	 * @param  string $scheme (optional)
	 * @param  bool   $hash   (optional)
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
	 * @param  string $color
	 *
	 * @return array
	 */
	public function get_color_css( $color ) {

		return ! empty( $this->colors[ $color ]['css'] ) ? $this->colors[ $color ]['css'] : array();

	}

	/**
	 * Register a color scheme setting.
	 *
	 * @action customize_register
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
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
	public function color_scheme_control_js() {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'primer-color-scheme-control', get_template_directory_uri() . "/assets/js/admin/color-scheme-control{$suffix}.js", array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), PRIMER_VERSION, true );

		wp_localize_script( 'primer-color-scheme-control', 'colorSchemes', $this->color_schemes );

	}

	/**
	 * Inline style for color scheme
	 *
	 * @action customize_controls_print_footer_scripts
	 */
	public function color_scheme_preview_css() {

		?>
		<script type="text/html" id="tmpl-primer-color-scheme-css">
			<?php

			foreach ( $this->colors as $name => $args ) {

				if ( empty( $name ) || empty( $args['css'] ) || ! is_array( $args['css'] ) ) {

					continue;

				}

				printf(
					Primer_Customizer::parse_css_rules( $args['css'] ),
					sprintf( '{{ data.%s }}', $name )
				);

			}

			?>
		</script>
		<?php

		$rgba_colors = $this->get_rgba_css();

		if ( ! $rgba_colors ) {

			// Required for themes without rgba css rules
			echo '<script type="text/html" id="tmpl-primer-color-scheme-css-rgba"></script>';

		}

		?>
		<script type="text/html" id="tmpl-primer-color-scheme-css-rgba">
			<?php

			foreach ( $rgba_colors as $name => $css ) {

				printf(
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
	 * @param  string $scheme
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
	 * @param  array $scheme
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
	 * @param  string $scheme
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
	 * Return an array of CSS for colors supporting RGBA.
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
		$args = (array) apply_filters( 'primer_custom_header_args',
			array(
				'default-text-color' => $this->get_default_color( 'header_textcolor', 'default' ),
				'width'              => 2400,
				'height'             => 1300,
				'flex-height'        => true,
				'wp-head-callback'   => array( $this, 'header_css' ),
			)
		);

		add_theme_support( 'custom-header', $args );

		/**
		 * Filter the default hero images.
		 *
		 * @var array
		 */
		$defaults = (array) apply_filters( 'primer_default_hero_images',
			array(
				'default' => array(
					'url'           => 'assets/images/hero.jpg',
					'thumbnail_url' => 'assets/images/hero-thumbnail.jpg',
					'description'   => esc_html__( 'City', 'primer' ),
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

			printf(
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
		$args = (array) apply_filters( 'primer_custom_background_args',
			array(
				'default-color' => $this->get_default_color( 'background_color', 'default' ),
			)
		);

		add_theme_support( 'custom-background', $args );

	}

}

new Primer_Customizer_Colors;
