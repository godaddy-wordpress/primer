<?php

class Primer_Customizer_Layouts {

	/**
	 * Array of custom layouts.
	 *
	 * @var array
	 */
	protected $layouts = array();

	/**
	 * Default layout key.
	 *
	 * @var string
	 */
	protected $default = 'two-column-default';

	/**
	 * Enable post/page overrides via meta box.
	 *
	 * @var bool
	 */
	protected $meta_box = true;

	/**
	 * Class constructor.
	 */
	public function __construct() {

		/**
		 * Filter the registered layouts.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$this->layouts = (array) apply_filters( 'primer_layouts',
			array(
				'one-column-wide'       => esc_html__( 'One Column: Wide', 'primer' ),
				'one-column-narrow'     => esc_html__( 'One Column: Narrow', 'primer' ),
				'two-column-default'    => esc_html__( 'Two Columns: Content | Sidebar', 'primer' ),
				'two-column-reversed'   => esc_html__( 'Two Columns: Sidebar | Content', 'primer' ),
				'three-column-default'  => esc_html__( 'Three Columns: Content | Sidebar | Sidebar', 'primer' ),
				'three-column-center'   => esc_html__( 'Three Columns: Sidebar | Content | Sidebar', 'primer' ),
				'three-column-reversed' => esc_html__( 'Three Columns: Sidebar | Sidebar | Content', 'primer' ),
			)
		);

		if ( ! $this->layouts ) {

			return;

		}

		add_action( 'after_setup_theme', array( $this, 'theme_support' ), 11 );
		add_action( 'init',              array( $this, 'rtl_layouts' ), 11 );
		add_action( 'init',              array( $this, 'post_type_support' ), 11 );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'load-post.php',         array( $this, 'load_post' ) );
		add_action( 'load-post-new.php',     array( $this, 'load_post' ) );
		add_action( 'save_post',             array( $this, 'save_post' ) );

		add_action( 'customize_register', array( $this, 'customize_register' ) );

		add_filter( 'body_class', array( $this, 'body_class' ) );

	}

	/**
	 * Apply theme support args.
	 *
	 * @action after_setup_theme
	 * @since  1.0.0
	 */
	public function theme_support() {

		$args    = (array) get_theme_support( 'primer-layouts' );
		$layouts = array_keys( $this->layouts );

		$this->default  = ( ! empty( $args[0] ) && $this->layout_exists( $args[0] ) ) ? $args[0] : ( $this->layout_exists( $this->default ) ? $this->default : array_shift( $layouts ) );
		$this->meta_box = ! empty( $args[1] ) ? (bool) $args[1] : $this->meta_box;

	}

	/**
	 * Alter some registered layouts when in RTL mode.
	 *
	 * @action init
	 * @since  1.0.0
	 */
	public function rtl_layouts() {

		if ( ! is_rtl() ) {

			return;

		}

		/**
		 * Filter changes needed for registered layouts when in RTL mode.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$rtl_layouts = (array) apply_filters( 'primer_layouts_rtl',
			array(
				'two-column-default'    => esc_html__( 'Two Columns: Sidebar | Content', 'primer' ),
				'two-column-reversed'   => esc_html__( 'Two Columns: Content | Sidebar', 'primer' ),
				'three-column-default'  => esc_html__( 'Three Columns: Sidebar | Sidebar | Content', 'primer' ),
				'three-column-reversed' => esc_html__( 'Three Columns: Content | Sidebar | Sidebar', 'primer' ),
			)
		);

		$this->layouts = array_merge( $this->layouts, $rtl_layouts );

	}

	/**
	 * Add post type support.
	 *
	 * @action init
	 * @since  1.0.0
	 */
	public function post_type_support() {

		/**
		 * Filter the post types that allow layouts.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$post_types = (array) apply_filters( 'primer_layouts_post_types', get_post_types( array( 'public' => true ) ) );

		foreach ( $post_types as $post_type ) {

			add_post_type_support( $post_type, 'primer-layouts' );

		}

	}

	/**
	 * Enqueue scripts and styles for post meta box.
	 *
	 * @action admin_enqueue_scripts
	 * @since  1.0.0
	 *
	 * @param string $hook
	 */
	public function admin_enqueue_scripts( $hook ) {

		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {

			return;

		}

		$rtl    = is_rtl() ? '-rtl' : '';
		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'primer-layouts-meta-box', get_template_directory_uri() . "/assets/js/meta-box{$suffix}.js", array( 'jquery' ), PRIMER_VERSION );

		wp_enqueue_style( 'primer-layouts-meta-box', get_template_directory_uri() . "/assets/css/meta-box{$rtl}{$suffix}.css", array(), PRIMER_VERSION );

	}

	/**
	 * Add a new meta box to post screens.
	 *
	 * @action load-post.php
	 * @action load-post-new.php
	 * @since  1.0.0
	 * @uses   $this->add_meta_box()
	 */
	public function load_post() {

		if ( $this->meta_box ) {

			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 10, 2 );

		}

	}

	/**
	 * Add post meta box for custom layouts.
	 *
	 * @see   $this->load_post()
	 * @since 1.0.0
	 * @uses  $this->render_meta_box()
	 *
	 * @param string  $post_type
	 * @param WP_Post $post
	 */
	public function add_meta_box( $post_type, WP_Post $post ) {

		if (
			! post_type_supports( $post_type, 'primer-layouts' )
			||
			! current_user_can( 'edit_post_meta', $post->ID )
			||
			! current_user_can( 'add_post_meta', $post->ID )
			||
			! current_user_can( 'delete_post_meta', $post->ID )
		) {

			return;

		}

		add_meta_box(
			'primer-layouts-meta-box',
			esc_html__( 'Layout', 'primer' ),
			array( $this, 'render_meta_box' ),
			$post_type,
			'side',
			'default'
		);

	}

	/**
	 * Display the custom layouts post meta box.
	 *
	 * @see   $this->add_meta_box()
	 * @since 1.0.0
	 *
	 * @param WP_Post $post
	 * @param string  $box
	 */
	public function render_meta_box( WP_Post $post, $box ) {

		$has_custom = ! empty( $this->get_post_layout( $post->ID ) );
		$global     = $this->get_global_layout();

		wp_nonce_field( basename( __FILE__ ), 'primer-layout-nonce' );

		?>
		<div class="primer-layout">

			<p>
			<?php

			printf(
				esc_html_x( 'The site-wide Default layout setting is located in the %s.', 'link to the Customizer', 'primer' ),
				sprintf(
					'<a href="%s">%s</a>',
					add_query_arg( 'autofocus[section]', 'layout', admin_url( 'customize.php' ) ),
					esc_html__( 'Customizer' )
				)
			);

			?>
			</p>

			<p>
				<label for="primer-layout-use-default"><input type="radio" name="primer-layout-override" id="primer-layout-use-default" value="0" <?php checked( ! $has_custom ) ?> autocomplete="off"><?php _e( 'Default', 'primer' ) ?></label>
				<label for="primer-layout-use-custom"><input type="radio" name="primer-layout-override" id="primer-layout-use-custom" value="1" <?php checked( $has_custom ) ?> autocomplete="off"><?php _e( 'Custom', 'primer' ) ?></label>
				<span class="clear"></span>
			</p>

			<div class="primer-layout-wrap">

				<ul>

					<?php foreach ( $this->layouts as $layout => $label ) :

						$class = ( $layout === $global ) ? 'active global' : '';

						if ( ! $class ) {

							$class = ( $has_custom ) ? 'active' : 'disabled';

						}

						?>
						<li class="<?php echo esc_attr( $class ) ?>">
							<label for="primer-layout-<?php echo esc_attr( $layout ) ?>">
								<input type="radio" name="primer-layout" id="primer-layout-<?php echo esc_attr( $layout ) ?>" value="<?php echo esc_attr( $layout ) ?>" <?php checked( $this->get_current_layout( $post->ID ), $layout ) ?> <?php disabled( 'disabled' === $class ) ?>>
								<img src="<?php echo esc_url( sprintf( '%s/assets/layouts/%s%s.svg', get_template_directory_uri(), $layout, is_rtl() ? '-rtl' : '' ) ) ?>" alt="<?php echo esc_attr( $label ) ?>" title="<?php echo esc_attr( $label ) ?>">
								<span><?php echo esc_html( $label ) ?></span>
							</label>
						</li>

					<?php endforeach; ?>

				</ul>

			</div>

		</div>
		<?php

	}

	/**
	 * Save layout post meta.
	 *
	 * @action save_post
	 * @since  1.0.0
	 *
	 * @param int $post_id
	 */
	public function save_post( $post_id ) {

		if (
			empty( $_POST['primer-layout-nonce'] )
			||
			! wp_verify_nonce( $_POST['primer-layout-nonce'], basename( __FILE__ ) )
		) {

			return;

		}

		$override = ! empty( $_POST['primer-layout-override'] );
		$current  = $this->get_post_layout( $post_id );

		if ( ! $override && $current ) {

			delete_post_meta( $post_id, 'primer_layout' );

			return;

		}

		$layout = isset( $_POST['primer-layout'] ) ? sanitize_key( $_POST['primer-layout'] ) : null;

		if ( ! $override || ! $this->layout_exists( $layout ) || $layout === $current ) {

			return;

		}

		update_post_meta( $post_id, 'primer_layout', $layout );

	}

	/**
	 * Register custom layout settings.
	 *
	 * @action customize_register
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function customize_register( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'layout',
			array(
				'title'      => esc_html__( 'Layout', 'primer' ),
				'priority'   => 30,
				'capability' => 'edit_theme_options'
			)
		);

		$wp_customize->add_setting(
			'layout',
			array(
				'default'           => get_theme_mod( 'layout', $this->default ),
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_html_class',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'layout',
			array(
				'label'       => esc_html__( 'Default Layout', 'primer' ),
				'description' => esc_html__( 'All posts and pages on your site will use this layout by default.', 'primer' ),
				'section'     => 'layout',
				'settings'    => 'layout',
				'type'        => 'radio',
				'choices'     => $this->layouts,
			)
		);

		$wp_customize->add_setting(
			'full_width',
			array(
				'default'           => 0,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'full-width',
			array(
				'label'       => esc_html__( 'Header & Footer Width', 'primer' ),
				'description' => esc_html__( 'Set the header and footer width to be fixed or fluid when viewed on large screens.', 'primer' ),
				'section'     => 'layout',
				'settings'    => 'full_width',
				'type'        => 'radio',
				'choices'     => array(
					0 => esc_html__( 'Fixed', 'primer' ),
					1 => esc_html__( 'Fluid', 'primer' ),
				),
			)
		);

	}

	/**
	 * Add layout class to body element on the front-end.
	 *
	 * @filter body_class
	 * @since  1.0.0
	 *
	 * @param  array $classes
	 *
	 * @return array
	 */
	public function body_class( array $classes ) {

		$classes[] = sanitize_html_class( sprintf( 'layout-%s', $this->get_current_layout() ) );
		$classes[] = (bool) get_theme_mod( 'full_width' ) ? 'no-max-width' : null;

		return array_filter( $classes );

	}

	/**
	 * Check if a layout exists.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $layout
	 *
	 * @return bool
	 */
	protected function layout_exists( $layout ) {

		return isset( $this->layouts[ $layout ] );

	}

	/**
	 * Return a post ID.
	 *
	 * @param  WP_Post|int $post (optional)
	 *
	 * @return string
	 */
	protected function get_post_id( $post = null ) {

		return is_a( 'WP_Post', $post ) ? $post->ID : ( is_numeric( $post ) ? absint( $post ) : get_queried_object_id() );

	}

	/**
	 * Return the layout override for a post.
	 *
	 * @param  WP_Post|int $post (optional)
	 *
	 * @return string
	 */
	protected function get_post_layout( $post = null ) {

		return get_post_meta( $this->get_post_id( $post ), 'primer_layout', true );

	}

	/**
	 * Return the global layout.
	 *
	 * @return string
	 */
	public function get_global_layout() {

		return get_theme_mod( 'layout', $this->default );

	}

	/**
	 * Return the current layout.
	 *
	 * @param  WP_Post|int $post (optional)
	 *
	 * @return string
	 */
	public function get_current_layout( $post = null ) {

		$override = $this->get_post_layout( $post );
		$layout   = ( $override ) ? $override : $this->get_global_layout();

		return $this->layout_exists( $layout ) ? $layout : $this->default;

	}

}

$GLOBALS['primer_customizer_layouts'] = new Primer_Customizer_Layouts;
