<?php
/**
 * Template part for displaying the page title inside The Loop.
 *
 * @package Primer
 */
?>

<header class="page-header">

	<?php do_action( 'primer_before_page_title' ) ?>

	<?php if ( is_singular() ) : ?>

		<h1 class="page-title"><?php the_title() ?></h1>

	<?php else : ?>

		<h2 class="page-title"><a href="<?php the_permalink() ?>" rel="permalink"><?php the_title() ?></a></h2>

	<?php endif; ?>

	<?php do_action( 'primer_after_page_title' ) ?>

</header><!-- .entry-header -->
