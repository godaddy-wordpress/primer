module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

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
					text_domain: 'primer', //Your text domain. Produces my-text-domain.pot
					dest: 'languages/', //directory to place the pot file
					keywords: [ //WordPress localisation functions
						'__:1',
						'_e:1',
						'_x:1,2c',
						'esc_html__:1',
						'esc_html_e:1',
						'esc_html_x:1,2c',
						'esc_attr__:1',
						'esc_attr_e:1',
						'esc_attr_x:1,2c',
						'_ex:1,2c',
						'_n:1,2',
						'_nx:1,2,4c',
						'_n_noop:1,2',
						'_nx_noop:1,2,3c'
					],
				},
				files:{
					src:  [ '**/*.php' ], //Parse all php files
					expand: true,
				}
		},

		phplint: {
			options: {
				swapPath: '/.phplint'
			},
			all: ['**/*.php']
		},

		browserSync: {
		    dev: {
			bsFiles: {
				src: [
					"*.css",
					"**/*.php",
					"*.js"
				]
			},
			options: {
				//proxy: "localhost", // enter your local WP URL here
				watchTask: true
			}
		    }
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
		}
	});


	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-browser-sync');
	grunt.loadNpmTasks('grunt-cssjanus');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-pot');
	grunt.registerTask('default',['browserSync', 'watch']);
	grunt.registerTask('lint',['jshint']);
	grunt.registerTask('translate',['pot']);

};
