<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#footer-php
 *
 * @package Primer
 */
?>

		</div><!-- #content -->

		<?php do_action( 'primer_before_footer' ) ?>

		<footer id="colophon" class="site-footer" role="contentinfo">

			<div class="site-footer-inner">

				<?php do_action( 'primer_footer' ) ?>

			</div><!-- .site-footer-inner -->

		</footer><!-- #colophon -->

		<?php do_action( 'primer_after_footer' ) ?>

	</div><!-- #page -->

	<?php wp_footer() ?>

</body>

</html>
