<?php

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

abstract class Primer_Base_Widget extends WP_Widget {

	/**
	 * Default properties for fields
	 *
	 * @var array
	 */
	protected $field_defaults = array(
		'key'            => '',
		'icon'           => '',
		'class'          => 'widefat',
		'id'             => '',
		'name'           => '',
		'label'          => '',
		'label_after'    => false,
		'description'    => '',
		'type'           => 'text',
		'sanitizer'      => 'sanitize_text_field',
		'escaper'        => 'esc_html',
		'form_callback'  => 'render_form_input',
		'default'        => '', // If you need a default value
		'value'          => '',
		'placeholder'    => '',
		'sortable'       => true,
		'atts'           => '', // Input attributes
		'show_front_end' => true, // Are we showing this field on the front end?
		'show_empty'     => false, // Show the field even if value is empty
		'select_options' => array(), // Only used if type=select & form_callback=render_form_select
	);

	/**
	 * Holds fields array for other function to access.
	 *
	 * @var array
	 */
	private $fields;

	/**
	 * Widget base constructor
	 *
	 * @param string $id_base
	 * @param string $name
	 * @param array  $widget_options
	 */
	public function __construct( $id_base, $name, array $widget_options ) {

		parent::__construct( $id_base, $name, $widget_options );

	}

	/**
	 * Add common ressources needed for the form
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {

		add_action( 'admin_footer',                            array( $this, 'enqueue_scripts' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_customizer_scripts' ) );

		?>
		<script>
			( function ( $ ) {

				// This let us know that we appended a new widget to reset sortables
				$( document ).trigger( 'primer.widgets.change' );

			} )( jQuery );
		</script>
		<?php

	}

	/**
	 * Sanitize widget form values as they are saved
	 *
	 * @param  array $new_instance Values just sent to be saved.
	 * @param  array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$fields = $this->get_fields( $old_instance );

		// Force value for checkbox since they are not posted
		foreach ( $fields as $key => $field ) {

			if ( 'checkbox' === $field['type'] && ! isset( $new_instance[ $key ]['value'] ) ) {

				$new_instance[ $key ] = array( 'value' => 'no' );

			}

		}

		// Starting at 1 since title order is 0
		$order = 1;

		foreach ( $new_instance as $key => &$instance ) {

			$sanitizer_callback = $fields[ $key ]['sanitizer'];

			// Title can't be an array
			if ( 'title' === $key ) {

				$instance = $sanitizer_callback( $instance['value'] );

				continue;

			}

			$instance['value'] = $sanitizer_callback( $instance['value'] );
			$instance['order'] = $order++;

		}

		return $new_instance;

	}

	/**
	 * Initialize fields for use on front-end of forms
	 *
	 * @param  array $instance
	 * @param  array $fields (optional)
	 * @param  bool  $ordered (optional)
	 *
	 * @return array
	 */
	protected function get_fields( array $instance, array $fields = array(), $ordered = true ) {

		$order = 0;

		foreach ( $fields as $key => &$field ) {

			$common_properties = array(
				'key'   => $key,
				'icon'  => $key,
				'order' => ! empty( $instance[ $key ]['order'] ) ? absint( $instance[ $key ]['order'] ) : $order,
				'id'    => $this->get_field_id( $key ),
				'name'  => $this->get_field_name( $key ) . '[value]',
				'value' => ! empty( $instance[ $key ]['value'] ) ? $instance[ $key ]['value'] : '',
			);

			$common_properties = wp_parse_args( $common_properties, $this->field_defaults );
			$field             = wp_parse_args( $field, $common_properties );

			$default_closure = function( $value ) { return $value;
			};

			foreach ( array( 'escaper', 'sanitizer' ) as $key ) {

				$field[ $key ] = ! is_callable( $field[ $key ] ) ? $default_closure : $field[ $key ];

			}

			$order++;

		}

		if ( $ordered ) {

			$fields = $this->order_field( $fields );

		}

		return $fields;

	}

	/**
	 * Order array by field order
	 *
	 * @param  array $fields
	 *
	 * @return array
	 */
	protected function order_field( array $fields ) {

	    $this->fields = $fields;

		uksort( $fields, array( $this, 'sort_order' ) );

		return $fields;

	}

	/**
	 * PHP 5.2 compatible uksort helper function.
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	private function sort_order( $a, $b ) {

		// We want title first and order of non sortable fields doesn't matter
		if ( ! $this->fields[ $a ]['sortable'] && 'title' !== $a ) {

			return 1;

		}

		return ( $this->fields[ $a ]['order'] < $this->fields[ $b ]['order'] ) ? -1 : 1;

	}

	/**
	 * Check if all the fields we show on the front-end are empty
	 *
	 * @param  array $fields
	 *
	 * @return bool
	 */
	protected function is_widget_empty( array $fields ) {

		foreach ( $fields as $key => $field ) {

			/**
			 * Filter to ignore the title when checking if a widget is empty
			 *
			 * @since NEXT
			 *
			 * @var bool
			 */
			$ignore_title = (bool) apply_filters( 'primer_is_widget_empty_ignore_title', false );

			if ( 'title' === $key && $ignore_title ) {

				continue;

			}

			if ( ! empty( $field['value'] ) && $field['show_front_end'] ) {

				return false;

			}

		}

		return true;

	}

	/**
	 * Print current label
	 *
	 * @param array $field
	 */
	protected function print_label( array $field ) {

		printf(
			' <label for="%s" title="%s">%s</label>',
			esc_attr( $field['id'] ),
			esc_attr( $field['description'] ),
			esc_html( $field['label'] )
		);

	}

	/**
	 * Print label and wrapper
	 *
	 * @param array $field
	 */
	protected function before_form_field( array $field ) {

		$classes = array( $field['type'], $field['key'] );

		if ( ! $field['sortable'] ) {

			$classes[] = 'not-sortable';

		}

		if ( $field['label_after'] ) {

			$classes[] = 'label-after';

		}

		printf(
			'<p class="%s">',
			implode( ' ', $classes )
		);

		if ( ! $field['label_after'] ) {

			$this->print_label( $field );

		}

		if ( $field['sortable'] ) {

			echo '<span>';

		}

	}

	/**
	 * Render input field for admin form
	 *
	 * @param array $field
	 */
	protected function render_form_input( array $field ) {

		$this->before_form_field( $field );

		printf(
			'<input class="%s" id="%s" name="%s" type="%s" value="%s" placeholder="%s" autocomplete="off" %s>',
			esc_attr( $field['class'] ),
			esc_attr( $field['id'] ),
			esc_attr( $field['name'] ),
			esc_attr( $field['type'] ),
			esc_attr( $field['value'] ),
			esc_attr( $field['placeholder'] ),
			esc_attr( $field['atts'] )
		);

		if ( $field['label_after'] ) {

			$this->print_label( $field );

		}

		$this->after_form_field( $field );

	}

	/**
	 * Render select field
	 *
	 * @param array $field
	 */
	protected function render_form_select( array $field ) {

		$this->before_form_field( $field );

		printf(
			'<select class="%s" id="%s" name="%s" autocomplete="off">',
			esc_attr( $field['class'] ),
			esc_attr( $field['id'] ),
			esc_attr( $field['name'] )
		);

		foreach ( $field['select_options'] as $value => $name ) {

			printf(
				'<option value="%s" %s>%s</option>',
				$value,
				$field['value'] === $value ? 'selected' : '',
				$name
			);

		}

		echo '</select>';

		if ( $field['label_after'] ) {

			$this->print_label( $field );

		}

		$this->after_form_field( $field );

	}

	/**
	 * Render textarea field for admin widget form
	 *
	 * @param array $field
	 */
	protected function render_form_textarea( array $field ) {

		$this->before_form_field( $field );

		printf(
			'<textarea class="%s" id="%s" name="%s" placeholder="%s">%s</textarea>',
			esc_attr( $field['class'] ),
			esc_attr( $field['id'] ),
			esc_attr( $field['name'] ),
			esc_attr( $field['placeholder'] ),
			esc_textarea( $field['value'] )
		);

		$this->after_form_field( $field );

	}

	/**
	 * Close wrapper of form field
	 *
	 * @param array $field
	 */
	protected function after_form_field( array $field ) {

		if ( $field['sortable'] ) {

			echo '<span class="primer-widget-sortable-handle"><span class="dashicons dashicons-menu"></span></span></span>';

		}

		echo '</p>';

	}

	/**
	 * Print beginning of front-end display
	 *
	 * @param array $args
	 * @param array $fields
	 */
	protected function before_widget( array $args, array &$fields ) {

		$title = array_shift( $fields );

		echo $args['before_widget'];

		if ( ! empty( $title['value'] ) ) {

			/**
			 * Filter the widget title
			 *
			 * @since NEXT
			 *
			 * @var string
			 */
			$title = (string) apply_filters( 'widget_title', $title['value'] );

			echo $args['before_title'] . $title . $args['after_title'];

		}

	}

	/**
	 * Print end of front-end display
	 *
	 * @param array $args
	 * @param array $fields
	 */
	protected function after_widget( array $args, array &$fields ) {

		echo $args['after_widget'];

	}

	/**
	 * Helper to output only 'checked' and not checked='checked'
	 * IE 9 & 10 don't support the latter
	 *
	 * @param mixed $helper  One of the values to compare
	 * @param mixed $current (true) The other value to compare if not just true
	 * @param bool  $echo    Whether to echo or just return the string
	 * @return string html attribute or empty string
	 */
	public function checked( $helper, $current, $echo = false ) {

		$result = (string) $helper === (string) $current ?  'checked' : '';

		if ( $echo ) {

			echo $result;

		}

		return $result;

	}

	/**
	 * Print footer script and styles
	 */
	public function enqueue_scripts() {}

	/**
	 * Print customizer script
	 */
	public function print_customizer_scripts() {

		$this->enqueue_scripts();

	}

}
