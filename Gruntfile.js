/* global module, require */

module.exports = function(grunt) {

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
						src: ['*.css','!*-rtl.css','!*.min.css','!*-rtl.min.css'],
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
					src: ['*.css', '!*.min.css'],
					dest: 'assets/css',
					ext: '.min.css'
				},
				{
					expand: true,
					cwd: 'assets/css/admin',
					src: ['*.css', '!*.min.css'],
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
			all: ['Gruntfile.js', 'assets/js/**/*.js', '!assets/js/**/*.min.js', '!assets/js/jquery.backgroundSize.js']
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
				src: 'languages/*.po*',
				overwrite: true,
				replacements: [
					{
						from: 'SOME DESCRIPTIVE TITLE.',
						to: pkg.title
					},
					{
						from: 'YEAR THE PACKAGE\'S COPYRIGHT HOLDER',
						to: new Date().getFullYear()
					},
					{
						from: 'FIRST AUTHOR <EMAIL@ADDRESS>, YEAR.',
						to: 'GoDaddy Operating Company, LLC.'
					},
					{
						from: 'charset=CHARSET',
						to: 'charset=UTF-8'
					}
				]
			}
		},

		sass: {
			options: {
				precision: 5,
				sourceMap: false
			},
			dist: {
				options: {
					require: 'susy'
				},
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
				tasks: ['sass','autoprefixer','cssjanus']
			},
			scripts: {
				files: ['Gruntfile.js', 'assets/js/**/*.js', '!assets/js/**/*.min.js'],
				tasks: ['jshint', 'uglify'],
				options: {
					interrupt: true
				}
			}
		}

	});

	require('matchdep').filterDev('grunt-*').forEach( grunt.loadNpmTasks );

	grunt.registerTask('default', ['sass', 'autoprefixer', 'cssjanus', 'cssmin', 'jshint', 'uglify']);
	grunt.registerTask('lint', ['jshint']);
	grunt.registerTask('update-pot', ['pot', 'replace:pot']);

};
