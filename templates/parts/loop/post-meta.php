	<div class="entry-meta">

		<span class="posted-meta">
			<?php printf( __( '%s by %s' , 'basis' ), basis_posted_on(), get_the_author_link() ); ?>
		</span>

		<span class="comments-number">
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				 &mdash;
				<a href="<?php the_permalink(); ?>#comments">
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'basis' ), __( '1 Comment', 'basis' ), __( '% Comments', 'basis' ) ); ?></span>
				</a>
			<?php endif; ?>
		</span>

	</div><!-- .entry-meta -->