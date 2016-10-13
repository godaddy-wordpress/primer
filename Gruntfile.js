/* global module, require */

module.exports = function( grunt ) {

	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.initConfig({

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
			dist: {
				src: [ '*.css', 'assets/css/**/*.css' ]
			}
		},

		clean: {
			mo: {
				src: [ 'languages/' + pkg.name + '-*.mo' ]
			}
		},

		copy: {
			mo: {
				files: [
					{
						expand: true,
						dot: true,
						cwd: 'languages/',
						dest: 'languages/',
						src: [ pkg.name + '-*.mo' ],
						rename: function( dest, src ) {
							return dest + src.replace( pkg.name + '-', '' );
						}
					}
				]
			}
		},

		cssjanus: {
			theme: {
				options: {
					swapLtrRtlInUrl: false
				},
				files: [
					{
						src: 'style.css',
						dest: 'style-rtl.css'
					},
					{
						src: 'editor-style.css',
						dest: 'editor-style-rtl.css'
					},
					{
						expand: true,
						cwd: 'assets/css/admin',
						src: [ '*.css','!*-rtl.css','!*.min.css','!*-rtl.min.css' ],
						dest: 'assets/css/admin',
						ext: '-rtl.css'
					}
				]
			}
		},

		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: 5,
				processImport: false
			},
			dist: {
				files: [{
					expand: true,
					cwd: 'assets/css',
					src: [ '*.css', '!*.min.css' ],
					dest: 'assets/css',
					ext: '.min.css'
				},
				{
					expand: true,
					cwd: 'assets/css/admin',
					src: [ '*.css', '!*.min.css' ],
					dest: 'assets/css/admin',
					ext: '.min.css'
				}]
			}
		},

		devUpdate: {
			main: {
				options: {
					updateType: 'force', //just report outdated packages
					reportUpdated: false, //don't report up-to-date packages
					semver: true, //stay within semver when updating
					packages: {
						devDependencies: true, //only check for devDependencies
						dependencies: false
					},
					packageJson: null, //use matchdep default findup to locate package.json
					reportOnlyPkgs: [] //use updateType action on all packages
				}
			}
		},

		jshint: {
			all: [ 'Gruntfile.js', 'assets/js/**/*.js', '!assets/js/**/*.min.js', '!assets/js/jquery.backgroundSize.js' ]
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

		po2mo: {
			files: {
				src: 'languages/*.po',
				expand: true
			}
		},

		sass: {
			options: {
				precision: 5,
				sourceMap: false
			},
			dist: {
				files: [
					{
						'style.css': '.dev/sass/style.scss',
						'editor-style.css': '.dev/sass/editor-style.scss'
					},
					{
						expand: true,
						cwd: '.dev/sass/admin',
						src: ['*.scss'],
						dest: 'assets/css/admin',
						ext: '.css'
					}
				]
			}
		},

		uglify: {
			options: {
				ASCIIOnly: true
			},
			dist: {
				expand: true,
				cwd: 'assets/js',
				src: ['*.js', '!*.min.js'],
				dest: 'assets/js',
				ext: '.min.js'
			},
			admin: {
				expand: true,
				cwd: 'assets/js/admin',
				src: ['*.js', '!*.min.js'],
				dest: 'assets/js/admin',
				ext: '.min.js'
			}
		},

		watch: {
			css: {
				files: '.dev/sass/**/*.scss',
				tasks: [ 'sass','autoprefixer','cssjanus' ]
			},
			scripts: {
				files: [ 'Gruntfile.js', 'assets/js/**/*.js', '!assets/js/**/*.min.js' ],
				tasks: [ 'jshint', 'uglify' ],
				options: {
					interrupt: true
				}
			}
		},

		replace: {
			version_php: {
				src: [
					'**/*.php',
					'.dev/**/*.scss'
				],
				overwrite: true,
				replacements: [ {
					from: /Version:(\s*?)[a-zA-Z0-9\.\-\+]+$/m,
					to: 'Version:$1' + pkg.version
				}, {
					from: /@version(\s*?)[a-zA-Z0-9\.\-\+]+$/m,
					to: '@version$1' + pkg.version
				}, {
					from: /@since(.*?)NEXT/mg,
					to: '@since$1' + pkg.version
				}, {
					from: /VERSION(\s*?)=(\s*?['"])[a-zA-Z0-9\.\-\+]+/mg,
					to: 'VERSION$1=$2' + pkg.version
				}, {
					from: /'PRIMER_VERSION', '[a-zA-Z0-9\.\-\+]+'/mg,
					to: '\'PRIMER_VERSION\', \'' + pkg.version + '\''
				}]
			},
			version_readme: {
				src: 'readme.*',
				overwrite: true,
				replacements: [ {
					from: /^(\*\*|)Stable tag:(\*\*|)(\s*?)[a-zA-Z0-9.-]+(\s*?)$/mi,
					to: '$1Stable tag:$2$3<%= pkg.version %>$4'
				} ]
			}
		}

	});

	require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );

	grunt.registerTask( 'default', [ 'sass', 'autoprefixer', 'cssjanus', 'cssmin', 'jshint', 'uglify' ] );
	grunt.registerTask( 'lint', [ 'jshint' ] );
	grunt.registerTask( 'update-pot', [ 'makepot' ] );
	grunt.registerTask( 'update-mo', [ 'po2mo', 'copy:mo', 'clean:mo' ] );
	grunt.registerTask( 'version', [ 'replace' ] );

};
