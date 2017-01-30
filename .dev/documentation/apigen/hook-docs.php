<?php
/**
 * Generate documentation for hooks in Primer
 */
class Primer_Hook_Finder {

	private static $staging_url = '';
	/**
	 * Current file
	 *
	 * @var string
	 */
	private static $current_file = '';

	/**
	 * Files to scan
	 *
	 * @var array
	 */
	private static $files_to_scan = array();

	/**
	 * REGEX do_action pattern
	 *
	 * @var string
	 */
	private static $pattern_custom_actions = '/do_action(.*?);/i';

	/**
	 * REGEX apply_filters pattern
	 *
	 * @var string
	 */
	private static $pattern_custom_filters = '/apply_filters(.*?);/i';

	/**
	 * Found files
	 *
	 * @var array
	 */
	private static $found_files = array();

	/**
	 * Custom hook found
	 *
	 * @var string/array
	 */
	private static $custom_hooks_found = '';

	/**
	 * Scan directory and return files
	 *
	 * @param  string  $pattern The pattern to match
	 * @param  bool    $flags   Sort flags
	 * @param  string  $path    Path to file
	 *
	 * @return array
	 *
	 * @since NEXT
	 */
	private static function get_files( $pattern, $flags = 0, $path = '' ) {

		if ( ! $path && ( $dir = dirname( $pattern ) ) != '.' ) {

			if ( '\\' == $dir || '/' == $dir ) {

				$dir = '';

			}

			return self::get_files( basename( $pattern ), $flags, $dir . '/' );

		}

		$paths = glob( $path . '*', GLOB_ONLYDIR | GLOB_NOSORT );
		$files = glob( $path . $pattern, $flags );

		if ( is_array( $paths ) ) {

			foreach ( $paths as $p ) {

				$found_files    = array();
				$retrieved_files = (array) self::get_files( $pattern, $flags, $p . '/' );

				foreach ( $retrieved_files as $file ) {

					if ( in_array( $file, self::$found_files ) ) {

						continue;

					}

					$found_files[] = $file;

				}

				self::$found_files = array_merge( self::$found_files, $found_files );

				if ( is_array( $files ) && is_array( $found_files ) ) {

					$files = array_merge( $files, $found_files );

				}

			}

		}

		return $files;

	}

	/**
	 * Get specific hook link
	 *
	 * @param  string $hook     Name of hook
	 * @param  array  $details  Hook data array
	 *
	 * @return mixed
	 *
	 * @since NEXT
	 */
	private static function get_hook_link( $hook, $details = array() ) {

		if ( ! empty( $details['class'] ) ) {

			$link = "source-function-{$details['class']}.html#{$details['line']}";

		} elseif ( ! empty( $details['function'] ) ) {

			$link = "source-function-{$details['function']}.html#{$details['line']}";

		} else {

			$link = "https://github.com/godaddy/wp-primer-theme/search?utf8=%E2%9C%93&q={$hook}";

		}

		return '<a href="' . $link . '">' . $hook . '</a>';

	}

	/**
	 * Process files, pull hooks & render table
	 *
	 * @return mixed
	 */
	public static function process_hooks() {

		$template_files   = self::get_files( '*.php', GLOB_MARK, '../../../templates/parts/' );

		$other_files = array(
			'../../../inc/hooks.php',
			'../../../inc/helpers.php',
			'../../../inc/template-tags.php',
		);

		self::$files_to_scan = array(
			'Template Hooks' => $template_files,
			'Other Hooks'    => $other_files,
		);

		$scanned = array();

		ob_start();

		echo '<div id="content">';
		echo '<h1>Action and Filter Hook Reference</h1>';

		foreach ( self::$files_to_scan as $heading => $files ) {

			self::$custom_hooks_found = array();

			foreach ( $files as $f ) {

				self::$current_file = basename( $f );
				$tokens             = token_get_all( file_get_contents( $f ) );
				$token_type         = false;
				$current_class      = '';
				$current_function   = '';

				if ( in_array( self::$current_file, $scanned ) ) {

					continue;

				}

				$scanned[] = self::$current_file;

				foreach ( $tokens as $index => $token ) {

					if ( is_array( $token ) ) {

						$trimmed_token_1 = trim( $token[1] );

						if ( T_CLASS == $token[0] ) {

							$token_type = 'class';

						} elseif ( T_FUNCTION == $token[0] ) {

							$token_type = 'function';

						} elseif ( 'do_action' === $token[1] ) {

							$token_type = 'action';

						} elseif ( 'apply_filters' === $token[1] ) {

							$token_type = 'filter';

						} elseif ( $token_type && ! empty( $trimmed_token_1 ) ) {

							switch ( $token_type ) {

								case 'class' :

									$current_class = $token[1];

								break;

								case 'function' :

									$current_function = $token[1];

								break;

								case 'filter' :
								case 'action' :

									$hook = trim( $token[1], "'" );
									$loop = 0;

									if ( '_' === substr( $hook, '-1', 1 ) ) {

										$hook .= '{';

										$open = true;

										// Keep adding to hook until we find a comma or colon
										while ( 1 ) {

											$loop ++;

											$next_hook  = trim( trim( is_string( $tokens[ $index + $loop ] ) ? $tokens[ $index + $loop ] : $tokens[ $index + $loop ][1], '"' ), "'" );

											if ( in_array( $next_hook, array( '.', '{', '}', '"', "'", ' ' ) ) ) {

												continue;

											}

											$hook_first = substr( $next_hook, 0, 1 );
											$hook_last  = substr( $next_hook, -1, 1 );

											if ( in_array( $next_hook, array( ',', ';' ) ) ) {

												if ( $open ) {

													$hook .= '}';

													$open = false;

												}

												break;

											}

											if ( '_' === $hook_first ) {

												$next_hook = '}' . $next_hook;

												$open = false;

											}

											if ( '_' === $hook_last ) {

												$next_hook .= '{';

												$open = true;

											}

											$hook .= $next_hook;

										}

									}

									if ( isset( self::$custom_hooks_found[ $hook ] ) ) {

										self::$custom_hooks_found[ $hook ]['file'][] = self::$current_file;

									} else {

										self::$custom_hooks_found[ $hook ] = array(
											'line'     => $token[2],
											'class'    => $current_class,
											'function' => $current_function,
											'file'     => array( self::$current_file ),
											'type'     => $token_type,
										);

									}

								break;

							}

							$token_type = false;

						}

					}

				}

			}

			foreach ( self::$custom_hooks_found as $hook => $details ) {

				if ( ! strstr( $hook, 'primer_' ) ) {

					unset( self::$custom_hooks_found[ $hook ] );

				}

			}

			ksort( self::$custom_hooks_found );

			if ( ! empty( self::$custom_hooks_found ) ) {

				echo '<div class="panel-heading"><h2>' . $heading . '</h2></div>';

				echo '<table class="summary table table-bordered table-striped"><thead><tr><th>Hook</th><th>Type</th><th>File(s)</th></tr></thead><tbody>';

				foreach ( self::$custom_hooks_found as $hook => $details ) {

					printf(
						'<tr>
							<td>%1$s</td>
							<td>%2$s</td>
							<td>%3$s</td>
						</tr>' . "\n",
						self::get_hook_link( $hook, $details ),
						$details['type'],
						implode( ', ', array_unique( $details['file'] ) )
					);

				}

				echo '</tbody></table></div>';

			}
		}

		echo '</div><div id="footer">';

		file_put_contents( '../en/documentation/hook-docs.html', ob_get_clean() );

		echo "Primer Hook documentation successfully generated!\n";

	}

}

Primer_Hook_Finder::process_hooks();
