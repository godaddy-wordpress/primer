/* global module, require */

module.exports = function( grunt ) {

	'use strict';

	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.initConfig( {

		pkg: pkg,

		autoprefixer: {
			options: {
				browsers: [
					'Android >= 2.1',
					'Chrome >= 21',
					'Edge >= 12',
					'Explorer >= 7',
					'Firefox >= 17',
					'Opera >= 12.1',
					'Safari >= 6.0'
				],
				cascade: false
			},
			editor: {
				src: [ 'editor-style.css' ]
			},
			main: {
				src: [ 'style.css' ]
			}
		},

		clean: {
			options: {
				force: true
			},
			build: [ 'build/*' ],
			docs: [ '.dev/docs/build/html/en/documentation/*' ]
		},

		copy: {
			build: {
				expand: true,
				cwd: '.',
				src: [
					'*.css',
					'*.php',
					'*.txt',
					'screenshot.png',
					'assets/**',
					'inc/**',
					'languages/**/*.{mo,pot}',
					'templates/**'
				],
				dest: 'build/'
			},
			docs: {
				expand: true,
				cwd: '.dev/docs/en/documentation/',
				src: [ '**/*' ],
				dest: '.dev/docs/build/html/en/documentation/'
			},
			readme: {
				expand: true,
				dot: true,
				cwd: '.',
				dest: '.dev/docs/en/',
				src: [ 'readme.md' ],
				rename: function( dest, src ) {
					return dest + src.replace( 'readme', 'intro' );
				}
			}
		},

		cssjanus: {
			options: {
				swapLtrRtlInUrl: false
			},
			assets: {
				expand: true,
				cwd: 'assets/css/',
				src: [ '**/*.css', '!**/*rtl.css', '!**/*min.css' ],
				dest: 'assets/css/',
				ext: '-rtl.css'
			},
			editor: {
				files: {
					'editor-style-rtl.css': 'editor-style.css'
				}
			},
			main: {
				files: {
					'style-rtl.css': 'style.css'
				}
			}
		},

		cssmin: {
			options: {
				processImport: false,
				roundingPrecision: 5,
				shorthandCompacting: false
			},
			assets: {
				expand: true,
				cwd: 'assets/css/',
				src: [ '**/*.css', '!**/*.min.css' ],
				dest: 'assets/css/',
				ext: '.min.css'
			}
		},

		devUpdate: {
			packages: {
				options: {
					packageJson: null,
					packages: {
						devDependencies: true,
						dependencies: false
					},
					reportOnlyPkgs: [],
					reportUpdated: false,
					semver: true,
					updateType: 'force'
				}
			}
		},

		imagemin: {
			options: {
				optimizationLevel: 3
			},
			assets: {
				expand: true,
				cwd: 'assets/images/',
				src: [ '**/*.{gif,jpeg,jpg,png,svg}' ],
				dest: 'assets/images/'
			},
			screenshot: {
				files: {
					'screenshot.png': 'screenshot.png'
				}
			}
		},

		jshint: {
			assets: [ 'assets/js/**/*.js', '!assets/js/**/*.min.js' ],
			gruntfile: [ 'Gruntfile.js' ]
		},

		makepot: {
			target: {
				options: {
					domainPath: 'languages/',
					include: [ '.+\.php' ],
					exclude: [ '.dev/', 'node_modules/' ],
					potComments: 'Copyright (c) {year} GoDaddy Operating Company, LLC. All Rights Reserved.',
					potHeaders: {
						'x-poedit-keywordslist': true
					},
					processPot: function( pot, options ) {
						pot.headers['report-msgid-bugs-to'] = pkg.bugs.url;
						return pot;
					},
					type: 'wp-theme',
					updatePoFiles: true
				}
			}
		},

		potomo: {
			files: {
				expand: true,
				cwd: 'languages/',
				src: [ '*.po' ],
				dest: 'languages/',
				ext: '.mo',
				rename: function( dest, src ) {
					return dest + src.replace( pkg.name + '-', '' );
				}
			}
		},

		replace: {
			docs: {
				overwrite: true,
				replacements: [
					{
						from: /Primer Theme v[\w.+-]+/m,
						to: 'Primer Theme v' + pkg.version
					}
				],
				src: [
					'.dev/docs/apigen/theme-godaddy/**/*.latte',
					'.dev/docs/themes/godaddy/**/*.html'
				]
			},
			intro: {
				overwrite: true,
				replacements: [
					{
						from: /^\[!\[(.|\n)*## Description ##/m, // Badges cause errors in the sphinx build process
						to: '## Description ##'
					},
					{
						from: /  $/gm,
						to: '<br />'
					}
				],
				src: [ '.dev/docs/en/intro.md' ]
			},
			php: {
				overwrite: true,
				replacements: [
					{
						from: /@since(\s+)NEXT/g,
						to: '@since$1<%= pkg.version %>'
					},
					{
						from: /'PRIMER_VERSION',(\s*)'[\w.+-]+'/,
						to: "'PRIMER_VERSION',$1'<%= pkg.version %>'"
					}
				],
				src: [ '*.php', 'inc/**/*.php', 'templates/**/*.php' ]
			},
			readme: {
				overwrite: true,
				replacements: [
					{
						from: /Stable tag:(\s*)[\w.+-]+/,
						to: 'Stable tag:$1<%= pkg.version %>'
					}
				],
				src: [ 'readme.txt' ]
			},
			sass: {
				overwrite: true,
				replacements: [
					{
						from: /Version:(\s*)[\w.+-]+/,
						to: 'Version:$1<%= pkg.version %>'
					}
				],
				src: [ '.dev/sass/**/*.scss' ]
			}
		},

		sass: {
			options: {
				precision: 5,
				sourceMap: false
			},
			assets: {
				expand: true,
				cwd: '.dev/sass/assets/',
				src: [ '**/*.scss' ],
				dest: 'assets/css/'
			},
			editor: {
				files: {
					'editor-style.css': '.dev/sass/editor-style.scss'
				}
			},
			main: {
				files: {
					'style.css': '.dev/sass/style.scss'
				}
			}
		},

		shell: {
			sphinx: [
				'easy_install pip',
				'pip install -r .dev/docs/requirements.txt',
				'cd .dev/docs',
				'make clean',
				'git clone -b gh-pages https://github.com/godaddy/wp-primer-theme.git build/html/en/',
				'make html'
			].join( ' && ' ),
			docs: [
				'apigen generate -q',
				'cd .dev/docs/apigen',
				'php contributor-list.php',
				'php hook-docs.php'
			].join( ' && ' ),
			deploy_docs: [
				'cd .dev/docs/build/html/en',
				'git add .',
				'git commit -m "Update Documentation"',
				'git push origin gh-pages --force'
			].join( ' && ' )
		},

		uglify: {
			options: {
				ASCIIOnly: true
			},
			assets: {
				expand: true,
				cwd: 'assets/js/',
				src: [ '**/*.js', '!**/*.min.js' ],
				dest: 'assets/js/',
				ext: '.min.js'
			}
		},

		watch: {
			images: {
				files: 'assets/images/**/*.{gif,jpeg,jpg,png,svg}',
				tasks: [ 'imagemin' ]
			},
			js: {
				files: 'assets/js/**/*.js',
				tasks: [ 'jshint', 'uglify' ]
			},
			sass: {
				files: '.dev/sass/**/*.scss',
				tasks: [ 'sass', 'autoprefixer', 'cssjanus', 'cssmin' ]
			}
		},

		wp_deploy: {
			options: {
				build_dir: 'build/',
				plugin_slug: pkg.name,
				svn_user: grunt.file.exists( 'svn-username' ) ? grunt.file.read( 'svn-username' ).trim() : ''
			}
		},

		wp_readme_to_markdown: {
			options: {
				post_convert: function( readme ) {
					var badges = {
						grunt: '[![Built with Grunt](https://cdn.gruntjs.com/builtwith.svg)](https://gruntjs.com)',
						david_dev: '[![devDependency Status](https://david-dm.org/' + pkg.repository + '/dev-status.svg)](https://david-dm.org/' + pkg.repository + '?type=dev)',
						php: '[![Required PHP Version](https://img.shields.io/badge/php-' + pkg.engines.php + '-8892bf.svg)](https://secure.php.net/supported-versions.php)',
						locales: '[![Supported Locales](https://img.shields.io/badge/locales-' + pkg.locales.length + '-orange.svg)]()',
						wordpress: '[![Required WordPress Version](https://img.shields.io/badge/wordpress-' + pkg.engines.wordpress + '-0073aa.svg)](https://wordpress.org/download/release-archive/)',
						travis: '[![Build Status](https://travis-ci.org/' + pkg.repository + '.svg?branch=master)](https://travis-ci.org/' + pkg.repository + ')',
						coveralls: '[![Coverage Status](https://coveralls.io/repos/' + pkg.repository + '/badge.svg?branch=master)](https://coveralls.io/github/' + pkg.repository + ')',
						license: '[![License](https://img.shields.io/github/license/' + pkg.repository + '.svg)](https://github.com/' + pkg.repository + '/blob/master/license.txt)'
					};

					// Required
					readme = readme.replace( '## Description ##', badges.grunt + "  \n\n## Description ##" );
					readme = addBadge( readme, badges.david_dev );

					// Extras
					readme = ( pkg.engines.php )                   ? addBadge( readme, badges.php )       : readme;
					readme = ( pkg.engines.wordpress )             ? addBadge( readme, badges.wordpress ) : readme;
					readme = ( pkg.locales.length > 0 )            ? addBadge( readme, badges.locales )   : readme;
					readme = grunt.file.exists( '.travis.yml' )    ? addBadge( readme, badges.travis )    : readme;
					readme = grunt.file.exists( '.coveralls.yml' ) ? addBadge( readme, badges.coveralls ) : readme;
					readme = grunt.file.exists( 'license.txt' )    ? addBadge( readme, badges.license )   : readme;

					return readme;
				}
			},
			all: {
				files: {
					'readme.md': 'readme.txt'
				}
			}
		}

	} );

	function addBadge( readme, badge ) {

		return readme.replace( " \n\n## Description ##", badge + "  \n\n## Description ##" );

	}

	require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );

	grunt.registerTask( 'default',     [ 'sass', 'autoprefixer', 'cssjanus', 'cssmin', 'jshint', 'uglify', 'imagemin' ] );
	grunt.registerTask( 'build',       [ 'default', 'clean:build', 'copy:build' ] );
	grunt.registerTask( 'check',       [ 'devUpdate' ] );
	grunt.registerTask( 'deploy',      [ 'wp_deploy', 'clean:build' ] );
	grunt.registerTask( 'deploy-docs', [ 'update-docs', 'shell:deploy_docs' ] );
	grunt.registerTask( 'readme',      [ 'wp_readme_to_markdown' ] );
	grunt.registerTask( 'update-docs', [ 'shell:sphinx', 'shell:docs', 'replace:docs', 'copy:readme', 'clean:docs', 'copy:docs', 'replace:intro' ] );
	grunt.registerTask( 'update-pot',  [ 'makepot' ] );
	grunt.registerTask( 'update-mo',   [ 'potomo' ] );
	grunt.registerTask( 'version',     [ 'replace', 'readme', 'build' ] );

};
