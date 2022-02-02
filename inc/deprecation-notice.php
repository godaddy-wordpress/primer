<?php
/**
 * Deprecation Notice bootstrap.
 *
 * @class    Primer_Deprecation_Notice
 * @package  Classes/Deprecation_Notice
 * @category Class
 * @author   GoDaddy
 * @since    NEXT
 */
class Primer_Deprecation_Notice {

	/**
	 * Class constructor.
	 */
	public function __construct() {

		if ( get_theme_mod( 'deprecation_notice_dismissed', false ) ) {

			return;

		}

		add_action( 'admin_notices', array( $this, 'deprecation_notice' ) );

		add_action( 'wp_ajax_dismiss_primer_deprecation_notice', array( $this, 'dismiss_primer_deprecation_notice' ) );

	}

	/**
	 * Show a dismissible admin notice about theme deprecation.
	 */
	public function deprecation_notice() {

		$class   = 'notice notice-warning is-dismissible primer-deprecation-notice';
		$message = sprintf(
			/* translators: 1: test */
			__( 'This theme will no longer receive support at the end of 2022. It is replaced by the free %1$s.', 'primer' ),
			sprintf(
				'<a href="https://wordpress.org/themes/go/" target="_blank" title="%1$s | WordPress.org">%1$s</a>',
				esc_html__( 'Go Theme', 'primer' )
			)
		);

		$this->print_dismissible_script();

		printf(
			'<div class="%1$s">
				<p>%2$s</p>
			</div>',
			esc_attr( $class ),
			wp_kses_post( $message )
		);

	}

	/**
	 * Update the theme mod to dismiss the deprecation notice.
	 */
	public function dismiss_primer_deprecation_notice() {

		set_theme_mod( 'deprecation_notice_dismissed', true );

		wp_die();

	}

	/**
	 * Print the dismissible deprecation notice script.
	 */
	public function print_dismissible_script() {

		?>
		<script type="text/javascript">
		( function( $ ) {
			$( function() {
				$( '.primer-deprecation-notice' ).on( 'click', '.notice-dismiss', function( event, el ) {
					jQuery.post(
						ajaxurl,
						{
							'action': 'dismiss_primer_deprecation_notice'
						}
					);
				} );
			} );
		} )( jQuery );
		</script>
		<?php

	}

}

new Primer_Deprecation_Notice();
