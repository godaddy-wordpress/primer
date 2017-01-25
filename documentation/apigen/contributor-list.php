<?php
/**
 * Generate contributor list file
 */
class Primer_Contributor_List {

	/**
	 * API Endpoint
	 *
	 * @var string
	 */
	private static $endpoint = 'https://api.github.com/repos/godaddy/wp-primer-theme/contributors?anon=1';

	/**
	 * Current file
	 *
	 * @var string
	 */
	private static $current_file = '';

	/**
	 * API Request
	 *
	 * @return json
	 */
	public static function get_contributors() {

		// create curl resource
		$ch = curl_init();

		// set url
		curl_setopt( $ch, CURLOPT_URL, self::$endpoint );

		//return the transfer as a string
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );

		// $output contains the output string
		$output = curl_exec( $ch );

		// close curl resource to free up system resources
		curl_close( $ch );

		$response = json_decode( $output, true );

		if ( ! $response ) {

			return;

		}

		return $response;

	}

	/**
	 * Generate contributor file
	 *
	 * @return mixed
	 */
	public static function generate_file() {

		$contributors = self::get_contributors();

		if ( ! $contributors && empty( $contributors ) ) {

			return;

		}

		ob_start();

		echo '## Contributors

';

		foreach ( $contributors as $contributor ) {

			if ( ! isset( $contributor['html_url'] ) ) {

				continue;

			}

			echo '<section class="contributor-container"><a href="' . $contributor['html_url'] . '" target="_blank"><img src="' . $contributor['avatar_url'] . '" class="contributor-image" /> <br />' . $contributor['login'] . '</a></section>
';

		}

		file_put_contents( '../en/contributors.md', ob_get_clean() );

	}

	/**
	 * Generate the changelog
	 *
	 * @return mixed
	 */
	public static function generate_changelog() {

		ob_start();

		echo '## Changelog';

		$contents = file_get_contents( '../../readme.md' );

		$explode = explode( '## Changelog ##', $contents );

		echo $explode[1];

		file_put_contents( '../en/changelog.md', ob_get_clean() );

	}

}

Primer_Contributor_List::generate_file();
Primer_Contributor_List::generate_changelog();
