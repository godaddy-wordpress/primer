<?php

class AdminCest {

	public function _before( AcceptanceTester $I ) {

		$this->login( $I );

	}

	public function _after( AcceptanceTester $I ) {}

	private function login( AcceptanceTester $I ) {

		$I->amOnPage( wp_login_url() );
		$I->fillField( [ 'id' => 'user_login' ], 'admin' );
		$I->fillField( [ 'id' => 'user_pass' ], 'password' );
		$I->click( [ 'id' => 'wp-submit' ] );

	}

	public function pageLayout( AcceptanceTester $I ) {

		global $wpdb;

		$page_id = (int) $wpdb->get_var( "SELECT ID FROM `{$wpdb->posts}` WHERE `post_status` = 'publish' AND `post_type` = 'page' LIMIT 1;" );

		$I->wantTo( 'change the page layouts' );

		// 1 Column Wide
		$I->amOnPage( self_admin_url( "post.php?post={$page_id}&action=edit" ) );
		$I->selectOption( 'input[name=post-layout]', 'one-column-wide' );
		$I->click( [ 'id' => 'publish' ] );
		$I->amOnPage( get_permalink( $page_id ) );
		$I->seeElement( [ 'css' => 'body.layout-one-column-wide' ] );
		$I->seeElement( [ 'id' => 'secondary' ] );
		$I->dontSeeElement( [ 'id' => 'tertiary' ] );

		// 1 Column Narrow
		$I->amOnPage( self_admin_url( "post.php?post={$page_id}&action=edit" ) );
		$I->selectOption( 'input[name=post-layout]', 'one-column-narrow' );
		$I->click( [ 'id' => 'publish' ] );
		$I->amOnPage( get_permalink( $page_id ) );
		$I->seeElement( [ 'css' => 'body.layout-one-column-narrow' ] );
		$I->seeElement( [ 'id' => 'secondary' ] );
		$I->dontSeeElement( [ 'id' => 'tertiary' ] );

		// 2 Columns: Sidebar / Content
		$I->amOnPage( self_admin_url( "post.php?post={$page_id}&action=edit" ) );
		$I->selectOption( 'input[name=post-layout]', 'two-column-reversed' );
		$I->click( [ 'id' => 'publish' ] );
		$I->amOnPage( get_permalink( $page_id ) );
		$I->seeElement( [ 'css' => 'body.layout-two-column-reversed' ] );
		$I->seeElement( [ 'id' => 'secondary' ] );
		$I->dontSeeElement( [ 'id' => 'tertiary' ] );

		// 3 Columns: Content / Sidebar / Sidebar
		$I->amOnPage( self_admin_url( "post.php?post={$page_id}&action=edit" ) );
		$I->selectOption( 'input[name=post-layout]', 'three-column-default' );
		$I->click( [ 'id' => 'publish' ] );
		$I->amOnPage( get_permalink( $page_id ) );
		$I->seeElement( [ 'css' => 'body.layout-three-column-default' ] );
		$I->seeElement( [ 'id' => 'secondary' ] );
		$I->seeElement( [ 'id' => 'tertiary' ] );

		// 3 Columns: Sidebar / Content / Sidebar
		$I->amOnPage( self_admin_url( "post.php?post={$page_id}&action=edit" ) );
		$I->selectOption( 'input[name=post-layout]', 'three-column-center' );
		$I->click( [ 'id' => 'publish' ] );
		$I->amOnPage( get_permalink( $page_id ) );
		$I->seeElement( [ 'css' => 'body.layout-three-column-center' ] );
		$I->seeElement( [ 'id' => 'secondary' ] );
		$I->seeElement( [ 'id' => 'tertiary' ] );

		// 3 Columns: Sidebar / Sidebar / Content
		$I->amOnPage( self_admin_url( "post.php?post={$page_id}&action=edit" ) );
		$I->selectOption( 'input[name=post-layout]', 'three-column-reversed' );
		$I->click( [ 'id' => 'publish' ] );
		$I->amOnPage( get_permalink( $page_id ) );
		$I->seeElement( [ 'css' => 'body.layout-three-column-reversed' ] );
		$I->seeElement( [ 'id' => 'secondary' ] );
		$I->seeElement( [ 'id' => 'tertiary' ] );

		// Default
		$I->amOnPage( self_admin_url( "post.php?post={$page_id}&action=edit" ) );
		$I->selectOption( 'input[name=post-layout]', 'default' );
		$I->click( [ 'id' => 'publish' ] );
		$I->amOnPage( get_permalink( $page_id ) );
		$I->seeElement( [ 'css' => 'body.layout-two-column-default' ] );
		$I->seeElement( [ 'id' => 'secondary' ] );
		$I->dontSeeElement( [ 'id' => 'tertiary' ] );

	}

	private function primaryMenu( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'assign a primary menu' );

	}

	private function socialMenu( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'assign a social menu' );

	}

	private function customLogo( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'upload a custom logo' );

	}

	private function headerImage( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'upload a custom header image' );

	}

	private function backgroundImage( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'upload a custom background image' );

	}

	private function backgroundColor( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'change the background color' );

	}

	private function linkTextColor( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'change the link text color' );

	}

	private function mainTextColor( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'change the main text color' );

	}

	private function secondaryTextColor( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'change the secondary text color' );

	}

	private function sidebarWidgets( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'add widgets to the sidebar' );

	}

	private function secondarySidebarWidgets( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'add widgets to the secondary sidebar' );

	}

	private function footerSidebarWidgets( AcceptanceTester $I ) {

		// TODO: Make public

		$I->wantTo( 'add widgets to the footer sidebars' );

	}

}
