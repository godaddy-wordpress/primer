<?php
/**
 * Template part for displaying the archive title.
 *
 * @package Primer
 */
?>
<div class="page-title-container">

	<header class="archive-header">

		<h1 class="archive-title"><?php the_archive_title(); ?></h1>

		<?php if ( get_the_archive_description() ) : ?>

			<div class="archive-description"><?php the_archive_description(); ?></div>

		<?php endif; ?>

	</header><!-- .archive-header -->

</div><!-- .page-title-container -->
