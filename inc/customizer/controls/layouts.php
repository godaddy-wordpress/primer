<?php

class Primer_Customizer_Layouts_Control extends WP_Customize_Control {

	/**
	 * Enqueue some custom css for layout control.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {

		$rtl    = is_rtl() ? '-rtl' : '';
		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style(
			'primer-layouts',
			get_template_directory_uri() . "/assets/css/admin/layouts{$rtl}{$suffix}.css",
			array(),
			PRIMER_VERSION
		);

		wp_enqueue_script(
			'primer-layouts',
			get_template_directory_uri() . "/assets/js/admin/layouts{$suffix}.js",
			array( 'customize-controls' ),
			true
		);

		$layouts = array();

		/**
		 * Identify which layouts are in the same category
		 */
		foreach ( $this->choices as $key => $label ) {

			list( $number ) = explode( '-', $key );

			$layouts[ $key ] = $number;

		}

		/**
		 * Filter layouts transport mechanism in the customizer. Either postMessage or refresh.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		$layouts = (array) apply_filters( 'primer_layouts_transport', $layouts );

		wp_localize_script(
			'primer-layouts',
			'primer_layouts_transport',
			$layouts
		);

	}

	/**
	 * Display layout choices in the Customizer.
	 *
	 * @global Primer_Customizer_Layouts $primer_customizer_layouts
	 * @since 1.0.0
	 */
	protected function render_content() {

		global $primer_customizer_layouts;

		if ( ! empty( $this->label ) ) {

			printf( '<span class="customize-control-title">%s</span>', esc_html( $this->label ) );

		}

		if ( ! empty( $this->description ) ) {

			printf( '<span class="description customize-control-description">%s</span>', esc_html( $this->description ) );

		}

		$primer_customizer_layouts->print_layout_choices( $this->choices );

	}

}
