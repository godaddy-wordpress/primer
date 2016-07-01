<?php

class FrontendCest {

	public function _before( AcceptanceTester $I ) {}

	public function _after( AcceptanceTester $I ) {}

	public function stickyPost( AcceptanceTester $I ) {

		$I->wantTo( 'verify sticky post' );
		$I->amOnPage( get_permalink( get_option( 'page_for_posts' ) ) );
		$I->seeElement( [ 'css' => '#main > article:first-child.hentry.sticky' ] );

	}

}
