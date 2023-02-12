/* global module, require */

module.exports = function( grunt ) {

	'use strict';

	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.initConfig( {

		pkg: pkg,

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

		postcss: {
			options: {
				map: false, // inline sourcemaps
				processors: [
					require( 'autoprefixer' ), // add vendor prefixes
				]
			},
			dist: {
				src: [ 'style.css', 'editor-style.css', 'assets/css/**/*.css', '!assets/css/**/*.min.css' ],
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

		image: {
			assets: {
				files: [ {
					expand: true,
					cwd: 'assets/images/',
					src: [ '**/*.{gif,jpeg,jpg,png,svg}' ],
					dest: 'assets/images/'
				} ]
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
				implementation: require( 'node-sass' ),
				precision: 5,
				sourceMap: false
			},
			admin: {
				files: {
					'assets/css/admin/customizer-fonts.css': '.dev/sass/admin/customizer-fonts.scss',
					'assets/css/admin/layouts.css': '.dev/sass/admin/layouts.scss'
				}
			},
			editor: {
				files: {
					'editor-style.css': '.dev/sass/editor-style.scss'
				}
			},
			layouts: {
				files: {
					'assets/css/admin/layouts.css': '.dev/sass/admin/layouts.scss'
				}
			},
			blocks: {
				files: {
					'assets/css/admin/editor-blocks.css': '.dev/sass/editor-blocks.scss'
				}
			},
			frame: {
				files: {
					'assets/css/admin/editor-frame.css': '.dev/sass/editor-frame.scss'
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
				'if [ -z "$TRAVIS" ]; then easy_install pip; pip install -r .dev/docs/requirements.txt; else sudo easy_install pip; sudo pip install -r .dev/docs/requirements.txt; fi',
				'cd .dev/docs',
				'make clean',
				'git clone -b gh-pages https://github.com/godaddy/wp-primer-theme.git build/html',
				'make html'
			].join( ' && ' ),
			docs: [
				'cd .dev/docs/apigen',
				'php contributor-list.php',
				'php hook-docs.php',
				'cd ../../../',
				'if [ -z "$TRAVIS" ]; then apigen generate --config .dev/docs/apigen/apigen.neon; else vendor/bin/apigen generate --config .dev/docs/apigen/apigen.neon; fi',
			].join( ' && ' ),
			deploy_docs: [
				'cd .dev/docs/build/html',
				'git add .',
				'git commit -m "Update Documentation" || true',
				'if [ -z "$TRAVIS" ]; then git push origin gh-pages --force; else git push -f -q https://$GH_PAGES_DEPLOY_KEY@github.com/godaddy/wp-primer-theme.git gh-pages; fi',
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
				tasks: [ 'image' ]
			},
			js: {
				files: 'assets/js/**/*.js',
				tasks: [ 'jshint', 'uglify' ]
			},
			sass: {
				files: '.dev/sass/**/*.scss',
				tasks: [ 'sass', 'replace:charset', 'postcss', 'cssjanus', 'cssmin' ]
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

	grunt.registerTask( 'default',     [ 'sass', 'replace:charset', 'postcss', 'cssjanus', 'cssmin', 'jshint', 'uglify', 'image' ] );
	grunt.registerTask( 'readme',      [ 'wp_readme_to_markdown' ] );
	grunt.registerTask( 'update-docs', [ 'readme', 'clean:docs', 'replace:docs_version', 'replace:docs', 'shell:sphinx', 'shell:docs', 'copy:readme', 'copy:docs_html', 'copy:docs_landing', 'replace:intro' ] );
	grunt.registerTask( 'deploy-docs', [ 'update-docs', 'shell:deploy_docs' ] );
	grunt.registerTask( 'update-pot',  [ 'makepot' ] );
	grunt.registerTask( 'update-mo',   [ 'potomo' ] );
	grunt.registerTask( 'version',     [ 'replace', 'readme', 'default', 'clean' ] );

};
