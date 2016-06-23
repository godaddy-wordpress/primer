<?php

class AdminCest {

    public function _before( AcceptanceTester $I ) {

        $this->login( $I );

    }

    public function _after( AcceptanceTester $I ) {}

    protected function login( AcceptanceTester $I ) {

        static $cookie = null;

        if ( ! is_null( $cookie ) ) {

            $I->setCookie( AUTH_COOKIE, $cookie );

            return;

        }

        $I->wantTo( 'log into wp-admin' );
        $I->amOnPage( wp_login_url() );
        $I->fillField( [ 'id' => 'user_login' ], 'admin' );
        $I->fillField( [ 'id' => 'user_pass' ], 'password' );
        $I->click( [ 'id' => 'wp-submit' ] );

        $cookie = $I->grabCookie( AUTH_COOKIE );

    }

    public function pageLayout( AcceptanceTester $I ) {

        $I->wantTo( 'change the page layout' );
        $I->amOnPage( self_admin_url( 'post.php?post=2&action=edit' ) );
        $I->selectOption( 'input[name=post-layout]', 'one-column-narrow' );
        $I->click( [ 'id' => 'publish' ] );
        $I->amOnPage( home_url( '?p=2' ) );
        $I->seeElement( 'body.layout-one-column-narrow' );
        $I->dontSeeElement( [ 'id' => 'secondary' ] );

    }

    public function primaryMenu( AcceptanceTester $I ) {

        $I->wantTo( 'assign a primary menu' );

    }

    public function socialMenu( AcceptanceTester $I ) {

        $I->wantTo( 'assign a social menu' );

    }

    public function customLogo( AcceptanceTester $I ) {

        $I->wantTo( 'upload a custom logo' );

    }

    public function headerImage( AcceptanceTester $I ) {

        $I->wantTo( 'upload a custom header image' );

    }

    public function backgroundImage( AcceptanceTester $I ) {

        $I->wantTo( 'upload a custom background image' );

    }

    public function backgroundColor( AcceptanceTester $I ) {

        $I->wantTo( 'change the background color' );

    }

    public function linkTextColor( AcceptanceTester $I ) {

        $I->wantTo( 'change the link text color' );

    }

    public function mainTextColor( AcceptanceTester $I ) {

        $I->wantTo( 'change the main text color' );

    }

    public function secondaryTextColor( AcceptanceTester $I ) {

        $I->wantTo( 'change the secondary text color' );

    }

    public function sidebarWidgets( AcceptanceTester $I ) {

        $I->wantTo( 'add widgets to the sidebar' );

    }

    public function secondarySidebarWidgets( AcceptanceTester $I ) {

        $I->wantTo( 'add widgets to the secondary sidebar' );

    }

    public function footerSidebarWidgets( AcceptanceTester $I ) {

        $I->wantTo( 'add widgets to the footer sidebars' );

    }

}
