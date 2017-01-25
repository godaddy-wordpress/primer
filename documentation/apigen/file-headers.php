<?php
/**
 * Generate documentation for hooks in Primer
 */
class Primer_File_Headers {

	public static function append_headers() {

		$html = file_get_contents( '../build/html/en/404.html' );

		$header = explode( '<div class="container page-container">', str_replace( '_static/', '../_static/', $html ) );

		$footer = explode( '<footer id="footer" class="footer-wrapper">', str_replace( '_static/', '../_static/', $html ) );

		foreach ( glob( '../en/documentation/*.html' ) as $file ) {

			$original_content = file_get_contents( $file );

			file_put_contents( $file, current( $header ) . $original_content . '<footer id="footer" class="footer-wrapper">' . end( $footer ) );

		}

	}

}

Primer_File_Headers::append_headers();
