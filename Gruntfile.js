module.exports = function(grunt) {

	var pkg = grunt.file.readJSON( 'package.json' );

	grunt.initConfig({

		pkg: pkg,

		sass: {
			dist: {
				files: {
					'style.css' : '.dev/sass/style.scss'
				}
			}
		},

		jshint: {
			all: ['js/**/*.js', 'Gruntfile.js']
		},

		autoprefixer: {
			options: {
				// Task-specific options go here.
			},
			your_target: {
				src: '*.css'
			},
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
					'inc/*.php',
					'templates/*.php'
				],
				expand: true,
			}
		},

		phplint: {
			options: {
				swapPath: '/.phplint'
			},
			all: ['**/*.php']
		},

		watch: {
			css: {
				files: '.dev/**/*.scss',
				tasks: ['sass','autoprefixer','cssjanus']
			},
			scripts: {
				files: ['js/**/*.js', 'Gruntfile.js' ],
				tasks: ['jshint'],
				options: {
					interrupt: true,
				}
			},
			pot: {
				files: [ '**/*.php' ],
				tasks: ['pot'],
			},
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
		}

	});

	require('matchdep').filterDev('grunt-*').forEach( grunt.loadNpmTasks );

	grunt.registerTask('default', ['watch']);
	grunt.registerTask('lint', ['jshint']);
	grunt.registerTask('update-pot', ['pot', 'replace:pot']);

};
