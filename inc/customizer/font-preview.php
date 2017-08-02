<?php

if ( ! class_exists( 'WP_Customize_Control' ) ) {

	return;

}

/**
 * Primer Font Preview Dropdown
 *
 * @since NEXT
 */
class Primer_Customizer_Font_Preview extends WP_Customize_Control {

	/**
	 * Render the font preview select field.
	 *
	 * @since NEXT
	 *
	 * @return mixed Markup for the select field.
	 */
	public function render_content() {

	?>

	<label>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

		<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>

		<select <?php $this->link(); ?>>

			<?php

			foreach ( $this->choices as $name => $label ) {

				printf(
					'<option value="%1$s">%2$s</option>',
					esc_attr( $name ),
					esc_html( $label )
				);

			}

			?>

		</select>

	</label>

	<?php

	}

}
