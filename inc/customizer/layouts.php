<?php
/**
 * Customizer Layouts functionality.
 *
 * @class    Primer_Customizer_Layouts
 * @package  Classes/Customizer
 * @category Class
 * @author   GoDaddy
 * @since    1.0.0
 */
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
	 * Array of page widths.
	 *
	 * @var bool
	 */
	protected $page_widths = array();

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

		/**
		 * Filter the default layout.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		$default       = (string) apply_filters( 'primer_default_layout', $this->default );
		$this->default = $this->layout_exists( $default ) ? $default : ( $this->layout_exists( $this->default ) ? $this->default : key( $this->layouts ) );

		/**
		 * Filter if post/page overrides via meta box should be enabled.
		 *
		 * @since 1.0.0
		 *
		 * @var bool
		 */
		$this->meta_box = (bool) apply_filters( 'primer_layouts_meta_box_enabled', $this->meta_box );

		/**
		 * Filter the registered page widths.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$this->page_widths = (array) apply_filters( 'primer_page_widths',
			array(
				'fixed' => /* translators: fixed-width page layout */ esc_html__( 'Fixed', 'primer' ),
				'fluid' => /* translators: fluid-width page layout */ esc_html__( 'Fluid', 'primer' ),
			)
		);

		add_action( 'init', array( $this, 'rtl_layouts' ), 11 );
		add_action( 'init', array( $this, 'post_type_support' ), 11 );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'customize_register',    array( $this, 'customize_register' ) );

		if ( $this->meta_box ) {

			add_action( 'load-post.php',     array( $this, 'load_post' ) );
			add_action( 'load-post-new.php', array( $this, 'load_post' ) );
			add_action( 'save_post',         array( $this, 'save_post' ) );

		}

		add_filter( 'body_class', array( $this, 'body_class' ) );

	}

	/**
	 * Alter some registered layouts when in RTL mode.
	 *
	 * @action init
	 * @uses   primer_layouts_rtl To filter the possible layouts.
	 *
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
	 * @uses [add_post_type_support](https://codex.wordpress.org/Function_Reference/add_post_type_support) To add layout support to specified post types.
	 *
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
	 * @param string $hook The suffix of the current admin page.
	 */
	public function admin_enqueue_scripts( $hook ) {

		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {

			return;

		}

		global $post;

		$rtl    = is_rtl() ? '-rtl' : '';
		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script(
			'primer-layouts',
			get_template_directory_uri() . "/assets/js/admin/layouts{$suffix}.js",
			array( 'jquery' ),
			PRIMER_VERSION
		);

		if ( isset( $post->ID ) ) {

			wp_localize_script( 'primer-layouts', 'primerLayouts', array(
				'selected' => $this->get_post_layout( $post->ID ),
			) );

		}

		wp_enqueue_style(
			'primer-layouts',
			get_template_directory_uri() . "/assets/css/admin/layouts{$rtl}{$suffix}.css",
			array(),
			PRIMER_VERSION
		);

	}

	/**
	 * Add a new meta box to post screens.
	 *
	 * @action load-post.php
	 * @action load-post-new.php
	 *
	 * @since  1.0.0
	 * @uses   $this->add_meta_box()
	 */
	public function load_post() {

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 10, 2 );

	}

	/**
	 * Add post meta box for custom layouts.
	 *
	 * @see   $this->load_post()
	 * @since 1.0.0
	 * @uses  $this->render_meta_box()
	 *
	 * @param string  $post_type Post type slug name.
	 * @param WP_Post $post      Post object.
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
			'default',
			null
		);

	}

	/**
	 * Display the custom layouts post meta box.
	 *
	 * @see   $this->add_meta_box()
	 * @since 1.0.0
	 *
	 * @param WP_Post $post Post object.
	 */
	public function render_meta_box( WP_Post $post ) {

		$current_layout = $this->get_post_layout( $post->ID );
		$has_custom = ! empty( $current_layout );

		wp_nonce_field( basename( __FILE__ ), 'primer-layout-nonce' );

		?>
		<div class="primer-layout">

			<p>
				<label for="primer-layout-use-default">
					<input type="radio" name="primer-layout-override" id="primer-layout-use-default" value="0" autocomplete="off" <?php checked( ! $has_custom ); ?>>
					<?php esc_html_e( 'Default', 'primer' ); ?>
				</label>
				<label for="primer-layout-use-custom">
					<input type="radio" name="primer-layout-override" id="primer-layout-use-custom" value="1" autocomplete="off" <?php checked( $has_custom ); ?>>
					<?php esc_html_e( 'Custom', 'primer' ); ?>
				</label>
				<span class="clear"></span>
			</p>

			<?php $this->print_layout_choices( $this->layouts, $post->ID, $current_layout, $has_custom ); ?>

		</div>
		<?php

	}

	/**
	 * Print all layouts choices to a meta-box or the Customizer.
	 *
	 * @global WP_Customize_Manager $wp_customize
	 * @since 1.0.0
	 *
	 * @param array  $layouts        Array of layouts.
	 * @param int    $post_id        (optional) Post ID. Default is `null`.
	 * @param string $current_layout (optional) Current layout slug name. Default is `null`.
	 * @param bool   $has_custom     (optional) Whether the current layout is a custom one. Default is `true`.
	 */
	public function print_layout_choices( $layouts, $post_id = null, $current_layout = null, $has_custom = true ) {

		global $wp_customize;

		$global_layout = $this->get_global_layout();

		if ( ! $current_layout ) {

			$current_layout = $global_layout;

		}

		$name = isset( $wp_customize ) ? '_customize-radio' : 'primer';

		?>
		<div class="primer-layout-wrap">

			<ul>
			<?php

			foreach ( $layouts as $layout => $label ) :

				$class = ( $has_custom ) ? 'active' : 'disabled';
				$class .= ( $layout === $global_layout ) ? ' active global' : '';

				?>
				<li class="<?php echo esc_attr( $class ); ?>">
					<label for="primer-layout-<?php echo esc_attr( $layout ); ?>">
						<input type="radio" name="<?php echo esc_attr( $name ); ?>-layout" data-customize-setting-link="layout" id="primer-layout-<?php echo esc_attr( $layout ); ?>" value="<?php echo esc_attr( $layout ); ?>" <?php checked( $current_layout, $layout ); ?> <?php disabled( 'disabled' === $class ); ?>>
						<img src="<?php echo esc_url( sprintf( '%s/assets/images/layouts/%s%s.svg', get_template_directory_uri(), $layout, is_rtl() ? '-rtl' : '' ) ); ?>"
							alt="<?php echo esc_attr( $label ); ?>"
							title="<?php echo esc_attr( $label ); ?>">
						<span><?php echo esc_html( $label ); ?></span>
					</label>
				</li>
				<?php

			endforeach;

			?>
			</ul>

		</div>
		<?php

	}

	/**
	 * Save layout post meta.
	 *
	 * @action save_post
	 * @since  1.0.0
	 *
	 * @param int $post_id Post ID.
	 */
	public function save_post( $post_id ) {

		if (
			empty( $_POST['primer-layout-nonce'] ) // input var ok.
			||
			! wp_verify_nonce( $_POST['primer-layout-nonce'], basename( __FILE__ ) ) // input var ok, sanitization ok.
		) {

			return;

		}

		$override = ! empty( $_POST['primer-layout-override'] ); // input var ok.
		$current  = $this->get_post_layout( $post_id );

		if ( ! $override && $current ) {

			delete_post_meta( $post_id, 'primer_layout' );

			return;

		}

		$layout = isset( $_POST['primer-layout'] ) ? sanitize_key( $_POST['primer-layout'] ) : null; // input var ok.

		if ( ! $override || ! $this->layout_exists( $layout ) || $layout === $current ) {

			return;

		}

		update_post_meta( $post_id, 'primer_layout', $layout );

	}

	/**
	 * Register custom layout settings.
	 *
	 * @action customize_register
	 * @see    WP_Customize_Manager
	 *
	 * @since  1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Instance of the WP_Customize_Manager class.
	 */
	public function customize_register( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'layout',
			array(
				'title'      => esc_html__( 'Layout', 'primer' ),
				'priority'   => 30,
				'capability' => 'edit_theme_options',
			)
		);

		if ( ! $this->page_widths ) {

			return;

		}

		reset( $this->page_widths );

		$wp_customize->add_setting(
			'page_width',
			array(
				'default'           => key( $this->page_widths ),
				'sanitize_callback' => 'sanitize_key',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'page_width',
			array(
				'label'       => esc_html__( 'Page Width', 'primer' ),
				'description' => esc_html__( 'Display your site differently on larger screens.', 'primer' ),
				'section'     => 'layout',
				'settings'    => 'page_width',
				'type'        => 'radio',
				'choices'     => $this->page_widths,
			)
		);

	}

	/**
	 * Add layout class to body element on the front-end.
	 *
	 * @filter body_class
	 * @since  1.0.0
	 *
	 * @param  array $classes Array of body classes.
	 *
	 * @return array Returns the filtered array of body classes.
	 */
	public function body_class( array $classes ) {

		$classes[] = sanitize_html_class( sprintf( 'layout-%s', $this->get_current_layout() ) );
		$classes[] = primer_is_fluid_width() ? 'no-max-width' : null;

		return array_filter( $classes );

	}

	/**
	 * Check if a layout exists.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $layout The layout name to check.
	 *
	 * @return bool Returns true if the layout is set, otherwise false.
	 */
	protected function layout_exists( $layout ) {

		return isset( $this->layouts[ $layout ] );

	}

	/**
	 * Return a post ID.
	 *
	 * @param  WP_Post|int $post (optional) The WP_Post object.
	 *
	 * @return int Returns the post ID.
	 */
	protected function get_post_id( $post = null ) {

		return is_a( 'WP_Post', $post ) ? $post->ID : ( is_numeric( $post ) ? absint( $post ) : get_queried_object_id() );

	}

	/**
	 * Return the layout override for a post.
	 *
	 * @param  WP_Post|int $post (optional) The WP_Post object.
	 *
	 * @return string Returns the post layout.
	 */
	protected function get_post_layout( $post = null ) {

		return get_post_meta( $this->get_post_id( $post ), 'primer_layout', true );

	}

	/**
	 * Return the global layout.
	 *
	 * @uses [get_theme_mod](https://codex.wordpress.org/Function_Reference/get_theme_mod) To retreive the layout mod.
	 *
	 * @return string Returns the layout theme modification.
	 */
	public function get_global_layout() {

		return get_theme_mod( 'layout', $this->default );

	}

	/**
	 * Return the current layout.
	 *
	 * @uses   get_post_layout
	 * @uses   get_global_layout
	 * @uses   layout_exists
	 *
	 * @param  WP_Post|int $post (optional) The WP_Post object.
	 *
	 * @return string Returns the current layout which is set.
	 */
	public function get_current_layout( $post = null ) {

		$override = $this->get_post_layout( $post );
		$layout   = ( $override ) ? $override : $this->get_global_layout();

		/**
		 * Filter the current layout.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Post|int|null $post
		 *
		 * @var string
		 */
		$layout = (string) apply_filters( 'primer_current_layout', $layout, $post );

		return $this->layout_exists( $layout ) ? $layout : $this->default;

	}

	/**
	 * Magic getter for `$colors` and `$color_schemes` properties.
	 *
	 * @since  1.8.0
	 *
	 * @param  string $name Name of private property to retreive.
	 *
	 * @return string Return the specified property within the `Primer_Customizer_Layouts` class.
	 */
	public function __get( $name ) {

		$properties = array( 'layouts', 'default', 'meta_box', 'page_widths' );

		return in_array( $name, $properties, true ) ? $this->name : false;

	}

}

$GLOBALS['primer_customizer_layouts'] = new Primer_Customizer_Layouts;
