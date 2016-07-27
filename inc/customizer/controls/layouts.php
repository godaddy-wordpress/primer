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

		wp_enqueue_style( 'primer-layouts', get_template_directory_uri() . "/assets/css/admin/layouts{$rtl}{$suffix}.css", array(), PRIMER_VERSION );

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
