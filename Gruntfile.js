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
			docs: [ '.dev/docs/sphinx/src/documentation/' ]
		},

		copy: {
			docs_html: {
				expand: true,
				cwd: '.dev/docs/sphinx/src/documentation/',
				src: [ '**/*' ],
				dest: '.dev/docs/build/html/documentation/'
			},
			docs_landing: {
				expand: true,
				cwd: '.dev/docs/sphinx/src/build/html/',
				src: [ '**/*.html' ],
				dest: '.dev/docs/build/html/'
			},
			readme: {
				expand: true,
				dot: true,
				cwd: '.',
				dest: '.dev/docs/sphinx/src/',
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
					exclude: [ '.dev/', 'node_modules/', 'tests/', 'vendor/' ],
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
			charset: {
				overwrite: true,
				replacements: [
					{
						from: /^@charset "UTF-8";\n/,
						to: ''
					}
				],
				src: [ 'style*.css' ]
			},
			docs: {
				overwrite: true,
				replacements: [
					{
						from: /Primer Theme v[\w.+-]+/m,
						to: 'Primer Theme v' + pkg.version
					}
				],
				src: [
					'.dev/docs/apigen/godaddy/**/*.latte',
					'.dev/docs/sphinx/godaddy/**/*.html'
				]
			},
			docs_version: {
				overwrite: true,
				replacements: [
					{
						from: /activeVersion: \'[\w.+-]+\'/m,
						to: 'activeVersion: \'' + pkg.version + '\''
					}
				],
				src: [
					'.dev/docs/apigen/godaddy/config.neon'
				]
			},
			intro: {
				overwrite: true,
				replacements: [
					{
						from: /^\[!\[(.|\r|\n)*## Description ##/m, // Badges cause errors in the sphinx build process
						to: '## Description ##'
					},
					{
						from: /  $/gm,
						to: '<br />'
					}
				],
				src: [ '.dev/docs/sphinx/src/intro.md' ]
			},
			php: {
				overwrite: true,
				replacements: [
					{
						from: /@deprecated(\s+)NEXT/g,
						to: '@deprecated$1<%= pkg.version %>'
					},
					{
						from: /@since(\s+)NEXT/g,
						to: '@since$1<%= pkg.version %>'
					},
					{
						from: /@NEXT/g,
						to: '<%= pkg.version %>'
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
				'git clone -b gh-pages git@github.com:godaddy/wp-primer-theme.git build/html',
				'make html'
			].join( ' && ' ),
			docs: [
				'cd .dev/docs/apigen',
				'php contributor-list.php',
				'php hook-docs.php',
				'cd ../../../',
				'apigen generate --config .dev/docs/apigen/apigen.neon',
			].join( ' && ' ),
			deploy_docs: [
				'cd .dev/docs/build/html',
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

		wp_readme_to_markdown: {
			options: {
				post_convert: function( readme ) {
					var matches = readme.match( /\*\*Tags:\*\*(.*)\r?\n/ ),
					    tags    = matches[1].trim().split( ', ' ),
					    section = matches[0];

					for ( var i = 0; i < tags.length; i++ ) {
						section = section.replace( tags[i], '[' + tags[i] + '](https://wordpress.org/themes/tags/' + tags[i] + '/)' );
					}

					// Tag links
					readme = readme.replace( matches[0], section );

					// Badges
					readme = readme.replace( '## Description ##', grunt.template.process( pkg.badges.join( ' ' ) ) + "  \r\n\r\n## Description ##" );

					// YouTube
					readme = readme.replace( /\[youtube\s+(?:https?:\/\/www\.youtube\.com\/watch\?v=|https?:\/\/youtu\.be\/)(.+?)\]/g, '[![Play video on YouTube](https://img.youtube.com/vi/$1/maxresdefault.jpg)](https://www.youtube.com/watch?v=$1)' );

					return readme;
				}
			},
			main: {
				files: {
					'readme.md': 'readme.txt'
				}
			}
		}

	} );

	require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );

	grunt.registerTask( 'default',     [ 'sass', 'replace:charset', 'autoprefixer', 'cssjanus', 'cssmin', 'jshint', 'uglify', 'imagemin' ] );
	grunt.registerTask( 'check',       [ 'devUpdate' ] );
	grunt.registerTask( 'deploy-docs', [ 'update-docs', 'shell:deploy_docs' ] );
	grunt.registerTask( 'readme',      [ 'wp_readme_to_markdown' ] );
	grunt.registerTask( 'update-docs', [ 'readme', 'clean:docs', 'replace:docs_version', 'replace:docs', 'shell:sphinx', 'shell:docs', 'copy:readme', 'copy:docs_html', 'copy:docs_landing', 'replace:intro' ] );
	grunt.registerTask( 'update-pot',  [ 'makepot' ] );
	grunt.registerTask( 'update-mo',   [ 'potomo' ] );
	grunt.registerTask( 'version',     [ 'replace', 'readme' ] );

};
