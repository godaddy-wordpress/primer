<?php

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

final class Primer_Starter_Content {

	public function __construct() {

		add_action( 'after_setup_theme', [ $this, 'starter_content' ] );

	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function starter_content() {

		add_theme_support(
			'starter-content',
			array(
				'widgets' => array(
					'sidebar-1' => array(
						'text_business_info',
						'search',
						'text_about',
					),
					'sidebar-2' => array(
						'text_business_info',
					),
					'sidebar-3' => array(
						'text_about',
						'search',
					),
				),

				'posts' => array(
					'home' => array(
						'post_content' => '<!-- wp:columns {"columns":3} -->
						<div class="wp-block-columns has-3-columns"><!-- wp:column -->
						<div class="wp-block-column"><!-- wp:image {"id":677} -->
						<figure class="wp-block-image"><img src="https://gutenberg.test/wp-content/uploads/2018/10/screen-1.jpg" alt="" class="wp-image-677"/></figure>
						<!-- /wp:image -->

						<!-- wp:heading -->
						<h2>' . esc_html__( 'Product / Service #1', 'primer' ) . '</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p>' . esc_html__( "Whatever your company is most known for should go right here, whether that's bratwurst or baseball caps or vampire bat removal.", 'primer' ) . '</p>
						<!-- /wp:paragraph --></div>
						<!-- /wp:column -->

						<!-- wp:column -->
						<div class="wp-block-column"><!-- wp:image {"id":678} -->
						<figure class="wp-block-image"><img src="https://gutenberg.test/wp-content/uploads/2018/10/screen-2.jpg" alt="" class="wp-image-678"/></figure>
						<!-- /wp:image -->

						<!-- wp:heading -->
						<h2>' . esc_html__( 'Product / Service #2', 'primer' ) . '</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p>' . esc_html__( "What's another popular item you have for sale or trade? Talk about it here in glowing, memorable terms so site visitors have to have it.", 'primer' ) . '</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p></p>
						<!-- /wp:paragraph --></div>
						<!-- /wp:column -->

						<!-- wp:column -->
						<div class="wp-block-column"><!-- wp:image {"id":679} -->
						<figure class="wp-block-image"><img src="https://gutenberg.test/wp-content/uploads/2018/10/screen-3.jpg" alt="" class="wp-image-679"/></figure>
						<!-- /wp:image -->

						<!-- wp:heading -->
						<h2>' . esc_html__( 'Product / Service #3', 'primer' ) . '</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p>' . esc_html__( "Don't think of this product or service as your third favorite, think of it as the bronze medalist in an Olympic medals sweep of great products/services.", 'primer' ) . '</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p></p>
						<!-- /wp:paragraph --></div>
						<!-- /wp:column --></div>
						<!-- /wp:columns -->

						<!-- wp:columns -->
						<div class="wp-block-columns has-2-columns"><!-- wp:column -->
						<div class="wp-block-column"><!-- wp:heading {"level":3} -->
						<h3>Your Main Message</h3>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p>Use this space to tell people what your company does and why and how it does it. What\'re you known for? Who likes you? What\'s your number one competitive advantage?</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Include all the things that make your business unique and better than the competition. Do you have a patented 13-step process for taxidermy that results in the most lifelike stuffed owls? You gotta mention that.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>Other good things to weave into this copy include: awards won, distinctions given, number of products sold, company philosophy (just keep it short), interesting company history bits, and anything that makes a reader think you\'d be awesome to do business with.</p>
						<!-- /wp:paragraph --></div>
						<!-- /wp:column -->

						<!-- wp:column -->
						<div class="wp-block-column"><!-- wp:image {"id":680,"align":"center"} -->
						<div class="wp-block-image"><figure class="aligncenter"><img src="https://gutenberg.test/wp-content/uploads/2018/10/screen-4.jpg" alt="" class="wp-image-680"/></figure></div>
						<!-- /wp:image --></div>
						<!-- /wp:column --></div>
						<!-- /wp:columns -->

						<!-- wp:columns {"columns":1} -->
						<div class="wp-block-columns has-1-columns"><!-- wp:column -->
						<div class="wp-block-column"><!-- wp:heading {"level":3} -->
						<h3>Next Steps…</h3>
						<!-- /wp:heading -->

						<!-- wp:columns -->
						<div class="wp-block-columns has-2-columns"><!-- wp:column -->
						<div class="wp-block-column"><!-- wp:paragraph -->
						<p>This is should be a prospective customer\'s number one call to action, e.g., requesting a quote or perusing your product catalog.</p>
						<!-- /wp:paragraph --></div>
						<!-- /wp:column -->

						<!-- wp:column -->
						<div class="wp-block-column"><!-- wp:paragraph {"align":"center"} -->
						<p style="text-align:center"><a href="#">Call to Action</a></p>
						<!-- /wp:paragraph --></div>
						<!-- /wp:column --></div>
						<!-- /wp:columns -->

						<!-- wp:paragraph -->
						<p></p>
						<!-- /wp:paragraph --></div>
						<!-- /wp:column --></div>
						<!-- /wp:columns -->',
					),
					'about' => array(
						'post_content' => '<p class="lead">Babybel cheese slices say cheese. Pepper jack red leicester macaroni cheese.</p><p>Cheese triangles caerphilly manchego cheese triangles fromage frais gouda melted cheese red leicester. Hard cheese port-salut caerphilly cheese slices cottage cheese fromage frais pecorino.</p><p><img src="https://unsplash.it/1600/500/?random" alt="Placeholder image"></p><blockquote class="blockquote"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p></blockquote><p><b>Cheesecake boursin cheese and wine. Ricotta swiss cheese strings fromage cheese and wine red leicester emmental croque monsieur.</b> Fondue smelly cheese red leicester lancashire when the cheese comes out everybodys happy emmental babybel when the cheese comes out everybodys happy.</p>',
					),
					'contact' => array(
						'thumbnail' => '{{image-espresso}}',
					),
					'blog' => array(
						'thumbnail' => '{{image-coffee}}',
					),
					'homepage-section' => array(
						'thumbnail' => '{{image-espresso}}',
					),
				),

				'attachments' => array(
					'image-espresso' => array(
						'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
						'file' => 'assets/images/espresso.jpg',
					),
					'image-sandwich' => array(
						'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
						'file' => 'assets/images/sandwich.jpg',
					),
					'image-coffee' => array(
						'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
						'file' => 'assets/images/coffee.jpg',
					),
				),

				'options' => array(
					'show_on_front' => 'page',
					'page_on_front' => '{{home}}',
					'page_for_posts' => '{{blog}}',
				),

				'theme_mods' => array(
					'panel_1' => '{{homepage-section}}',
					'panel_2' => '{{about}}',
					'panel_3' => '{{blog}}',
					'panel_4' => '{{contact}}',
				),

				'nav_menus' => array(
					'primary' => array(
						'name' => __( 'Top Menu', 'twentyseventeen' ),
						'items' => array(
							'page_home',
							'page_about',
							'page_blog',
							'page_contact',
						),
					),
					'social' => array(
						'name' => __( 'Social Links Menu', 'twentyseventeen' ),
						'items' => array(
							'link_facebook',
							'link_twitter',
							'link_instagram',
							'link_email',
						),
					),
				),
			)
		);

	}

}

new Primer_Starter_Content();
