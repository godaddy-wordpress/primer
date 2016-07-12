module.exports = function(grunt) {

	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.initConfig({

		pkg: pkg,

		autoprefixer: {
			options: {
				// Task-specific options go here.
			},
			your_target: {
				src: '*.css'
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
					}
				]
			}
		},

		jshint: {
			all: ['Gruntfile.js', 'assets/js/*.js', '!assets/js/*.min.js']
		},

		po2mo: {
			files: {
				src: 'languages/*.po',
				expand: true
			}
		},

		pot: {
			options:{
				omit_header: false,
				text_domain: pkg.name,
				encoding: 'UTF-8',
				dest: 'languages/',
				keywords: [
					'__',
					'_e',
					'__ngettext:1,2',
					'_n:1,2',
					'__ngettext_noop:1,2',
					'_n_noop:1,2',
					'_c',
					'_nc:4c,1,2',
					'_x:1,2c',
					'_nx:4c,1,2',
					'_nx_noop:4c,1,2',
					'_ex:1,2c',
					'esc_attr__',
					'esc_attr_e',
					'esc_attr_x:1,2c',
					'esc_html__',
					'esc_html_e',
					'esc_html_x:1,2c'
				],
				msgmerge: true
			},
			files:{
				src: [
					'*.php',
					'inc/**/*.php',
					'templates/**/*.php'
				],
				expand: true
			}
		},

		replace: {
			pot: {
				src: 'languages/' + pkg.name + '.pot',
				overwrite: true,
				replacements: [
					{
						from: 'charset=CHARSET',
						to: 'charset=UTF-8'
					}
				]
			}
		},

		sass: {
			options: {
				sourceMap: false
			},
			dist: {
				files: {
					'style.css': '.dev/sass/style.scss'
				}
			}
		},

		uglify: {
			options: {
				ASCIIOnly: true
			},
			core: {
				expand: true,
				cwd: 'assets/js',
				src: ['*.js', '!*.min.js'],
				dest: 'assets/js',
				ext: '.min.js'
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


		watch: {
			css: {
				files: '.dev/sass/**/*.scss',
				tasks: ['sass','autoprefixer','cssjanus']
			},
			scripts: {
				files: ['Gruntfile.js', 'assets/js/*.js', '!assets/js/*.min.js'],
				tasks: ['jshint', 'uglify'],
				options: {
					interrupt: true
				}
			},
			pot: {
				files: [ '**/*.php' ],
				tasks: ['update-pot']
			},
		}

	});

	require('matchdep').filterDev('grunt-*').forEach( grunt.loadNpmTasks );

	grunt.registerTask('default', ['watch']);
	grunt.registerTask('lint', ['jshint']);
	grunt.registerTask('update-pot', ['pot', 'replace:pot']);

};
