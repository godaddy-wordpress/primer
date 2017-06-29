<?php
/**
 * Hero Text Widget.
 *
 * @class      Primer_Hero_Text_Widget
 * @package    Classes
 * @subpackage Widgets
 * @category   Class
 * @author     GoDaddy
 * @since      1.6.0
 * @extends    WP_Widget
 */
class Primer_Hero_Text_Widget extends WP_Widget {

	/**
	 * Widget constructor.
	 */
	public function __construct() {

		$widget_options = array(
			'customize_selective_refresh' => true,
			'classname'                   => 'widget_text primer-widgets primer-hero-text-widget',
			'description'                 => sprintf(
				/* translators: theme name */
				esc_html__( "A %s theme widget designed for the Hero area on your site's front page.", 'primer' ),
				esc_html( $this->get_current_theme_name() )
			),
		);

		parent::__construct( 'primer-hero-text', /* translators: the widget title */ esc_html__( 'Hero Text', 'primer' ), $widget_options );

		add_action( 'admin_init', array( $this, 'register_scripts' ) );

	}

	/**
	 * Display the widget on the front-end.
	 *
	 * @since 1.6.0
	 *
	 * @param array $args     Display arguments including `before_title`, `after_title`, `before_widget`, and `after_widget`.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {

		/**
		 * Filter the widget title.
		 *
		 * @link  https://developer.wordpress.org/reference/hooks/widget_title/
		 * @since 1.6.0
		 *
		 * @param array  $instance An array of the widget's settings.
		 * @param string $id_base  The widget ID.
		 *
		 * @var string
		 */
		$title = ! empty( $instance['title'] ) ? (string) apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) : null;

		/**
		 * Filter the widget text.
		 *
		 * @link  https://developer.wordpress.org/reference/hooks/widget_text/
		 * @since 1.6.0
		 *
		 * @param array                   $instance    Array of settings for the current widget.
		 * @param Primer_Hero_Text_Widget $this        Current Hero Text widget instance.
		 *
		 * @var string
		 */
		$text = ! empty( $instance['text'] ) ? (string) apply_filters( 'widget_text', $instance['text'], $instance, $this ) : null;

		$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : null;
		$button_link = ! empty( $instance['button_link'] ) ? $instance['button_link'] : null;

		// The `button_link` can be empty.
		if ( ! $title && ! $text && ! $button_text ) {

			return;

		}

		echo $args['before_widget']; // xss ok.

		?>
		<div class="textwidget primer-widgets primer-hero-text-widget">

			<?php if ( $title ) : ?>

				<?php echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // xss ok. ?>

			<?php endif; ?>

			<?php if ( $text ) : ?>

				<?php echo wp_kses_post( wpautop( $text ) ); ?>

			<?php endif; ?>

			<?php if ( $button_text ) : ?>

				<p><a href="<?php echo esc_url( $button_link ); ?>" class="button"><?php echo esc_html( $button_text ); ?></a></p>

			<?php endif; ?>

		</div>
		<?php

		echo $args['after_widget']; // xss ok.

	}

	/**
	 * Display the widget form fields.
	 *
	 * @since 1.6.0
	 *
	 * @param array $instance The widget instance values.
	 */
	public function form( $instance ) {

		add_action( 'admin_print_footer_scripts',              array( $this, 'print_scripts' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_scripts' ) );

		$title       = isset( $instance['title'] )       ? $instance['title']       : null;
		$text        = isset( $instance['text'] )        ? $instance['text']        : null;
		$button_text = isset( $instance['button_text'] ) ? $instance['button_text'] : null;
		$button_link = isset( $instance['button_link'] ) ? $instance['button_link'] : null;

		?>
		<script type="text/javascript">
		( function ( $ ) {

			// Let our script know a widget has been added to make its URL search input work.
			$( document ).trigger( 'primer.widgets.change' );

		} )( jQuery );
		</script>

		<style type="text/css">
		input[type="text"].link.ui-autocomplete-loading {
			background-position: right 3px center;
		}
		</style>

		<div class="primer-widgets primer-hero-text-widget">

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" title="<?php esc_attr_e( 'The title of widget. Leave empty for no title.', 'primer' ); ?>"><?php esc_html_e( 'Title:', 'primer' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" autocomplete="off">
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text:', 'primer' ); ?></label>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" rows="6" cols="20"><?php echo esc_textarea( $text ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Button Text:', 'primer' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" value="<?php echo esc_attr( $button_text ); ?>" autocomplete="off">
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"><?php esc_html_e( 'Button Link URL:', 'primer' ); ?></label>
				<input type="text" class="widefat link" id="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_link' ) ); ?>" value="<?php echo esc_attr( $button_link ); ?>" placeholder="<?php esc_attr_e( 'Paste URL or type to search', 'primer' ); ?>" autocomplete="off">
			</p>

		</div>
		<?php

	}

	/**
	 * Update a widget instance.
	 *
	 * @since 1.6.0
	 *
	 * @param  array $new_instance New settings for this instance as input by the user via `WP_Widget::form()`.
	 * @param  array $old_instance Old settings for this instance.
	 *
	 * @return array Array of settings to save, or `false` to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title'] = ! empty( $new_instance['title'] ) ? trim( strip_tags( $new_instance['title'] ) ) : null;

		$instance['text'] = ! empty( $new_instance['text'] ) ? $new_instance['text'] : null;
		$instance['text'] = current_user_can( 'unfiltered_html' ) ? trim( $new_instance['text'] ) : trim( wp_kses_post( stripslashes( $new_instance['text'] ) ) );

		$instance['button_text'] = ! empty( $new_instance['button_text'] ) ? trim( strip_tags( $new_instance['button_text'] ) ) : null;
		$instance['button_link'] = ! empty( $new_instance['button_link'] ) ? esc_url_raw( trim( $new_instance['button_link'] ) ) : null;

		return $instance;

	}

	/**
	 * Register widget admin scripts.
	 *
	 * @action admin_init
	 * @since  1.6.0
	 */
	public function register_scripts() {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_register_script(
			'primer-admin-hero-text-widget',
			get_template_directory_uri() . "/assets/js/admin/hero-text-widget{$suffix}.js",
			array( 'jquery', 'jquery-ui-autocomplete' ),
			PRIMER_VERSION,
			true
		);

		// We need the internal linking token.
		wp_localize_script(
			'primer-admin-hero-text-widget',
			'primer_hero_text_widget',
			array(
				'_ajax_linking_nonce' => wp_create_nonce( 'internal-linking' ),
			)
		);

	}

	/**
	 * Print widget admin scripts.
	 *
	 * @action admin_print_footer_scripts
	 * @action customize_controls_print_footer_scripts
	 * @since  1.6.0
	 */
	public function print_scripts() {

		wp_print_scripts( 'primer-admin-hero-text-widget' );

	}

	/**
	 * Return the current theme name.
	 *
	 * Looks for the `current_theme` option first, and if not
	 * present will fetch it using `wp_get_theme()`.
	 *
	 * @since 1.6.0
	 *
	 * @return string
	 */
	protected function get_current_theme_name() {

		$current_theme = get_option( 'current_theme' );

		if ( $current_theme ) {

			return $current_theme;

		}

		$theme = wp_get_theme();

		return $theme->get( 'Name' );

	}

}
