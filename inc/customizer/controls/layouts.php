<?php

class Primer_Customizer_Layouts_Control extends WP_Customize_Control {

	protected function render_content() {

		global $primer_customizer_layouts;


		if ( ! empty( $this->label ) ) :?>

			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

		<?php endif;

		if ( ! empty( $this->description ) ) : ?>

			<span class="description customize-control-description"><?php echo $this->description ; ?></span>

		<?php endif;

		$primer_customizer_layouts->print_layout_choices( $this->choices );

		//parent::render_content();

	}

}
