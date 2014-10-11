<?php
/**
 * Browser Sync Module
 *
 * Enables the Browser Sync grunt module for local WordPress
 * development environments. Allows developers to sync their
 * CSS changes across connected clients over WI-FI networks.
 */


/*
* Wrap everything in a class for namespacing
*/
class browser_sync_localhost {

	/*
	 * define variables and call setup method from init
	 */
	public static function init() {

		//if DEVENV isn't defined in wp-config.php, bail
		if( !defined('DEVENV') || DEVENV !== true ){
			return;
		}

		//run plugin setup after plugins/themes are loaded
		add_action('after_setup_theme', array(__CLASS__, 'setup'));

		//Set Time Zone
		date_default_timezone_set('America/Chicago');

	}//end init method

	/*
	 * actions/hooks in setup, after plugins/themes are loaded
	 */
	public static function setup() {

		//add Browser Sync JS to footer if on localhost
		if( self::different_host() ){
			add_action( 'wp_footer', array(__CLASS__, 'browser_sync_js'), 9999 );
			add_filter('option_home', array(__CLASS__, 'url_filter'), 99, 1);
			add_filter('option_siteurl', array(__CLASS__, 'url_filter'), 99, 1);
			add_filter('stylesheet_directory_uri', array(__CLASS__, 'url_filter'), 99, 1);
			add_filter('template_directory_uri', array(__CLASS__, 'url_filter'), 99, 1);
		}

	}//end setup method

	/**
	* Get WordPress host from site url
	*/
	private static function wordpress_host(){

		$host_matches = array();

		global $wpdb;

		//get WordPress url from database
		$wordpress_url = $wpdb->get_var("SELECT `option_value` FROM $wpdb->options WHERE `option_name` = 'siteurl';");

		//remove www.
		$wordpress_url = str_replace('www.', '', $wordpress_url);

		//strip http, www, etc from wordpress url
		preg_match('|http://([^/]+)|',$wordpress_url, $host_matches);

		if( !empty($host_matches) AND isset($host_matches[1]) ){
			//if successful return wordpress host
			return $host_matches[1];
		} else{
			//otherwise return false
			return false;
		}

	}//end wordpress_host method

	/**
	* get localhost if defined
	*/
   private static function get_localhost(){

		$local_host = $_SERVER['HTTP_HOST'];

		//if localhost is empty, bail
		if( empty($local_host) ){
			return false;
		} else{
			//otherwise strip www and return
			return str_replace('www.', '', $local_host);
		}

	}//end get_localhost method

	/**
	* Does WordPress host differ from localhost?
	*/
	private static function different_host(){

		//get localhost
		$local_host = self::get_localhost();

		//if no localhost, bail
		if( $local_host === false ){
			return false;
		}

		//get WordPress host
		$wordpress_host = self::wordpress_host();

		//if no WordPress host, bail
		if( $wordpress_host === false ){
			return false;
		}

		//if wordpress host doesn't match the localhost return true, otherwise return false
		if( $wordpress_host != $current_host ){
			return true;
		} else{
			return false;
		}

	}//end different_host method

	/**
	* Add browser sync JS to footer
	*/
	public static function browser_sync_js() {
		echo "<script type='text/javascript'>//<![CDATA[
		document.write(\"<script async src='//HOST:3000/browser-sync-client.1.3.6.js'><\/script>\".replace(/HOST/g, 	location.hostname));
		//]]></script>";
	}//end browser_sync_js method

	/**
	* Filter URL, replacing localhost w/ IP
	*/
	public static function url_filter($url){

		//get WordPress host
		$wordpress_host = self::wordpress_host();

		//get localhost
		$local_host = self::get_localhost();

		//if current host is not the same as what's in WordPress filter the WordPress value
		if( self::different_host() ){
			$url = str_replace($wordpress_host, $local_host, $url );
		}

		return $url;

	}//end url_filter

}//end browser_sync_localhost

//run init
browser_sync_localhost::init();