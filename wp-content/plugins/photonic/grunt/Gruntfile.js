module.exports = function(grunt) {
	// Config
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		dirs: {
			src: '../include/scripts/front-end/src',
			dest: '../include/scripts/front-end/build',
			no_jq_src: '../include/scripts/front-end/src-no-jq',
			no_jq_dest: '../include/scripts/front-end/build-no-jq',
			i18n_src: '..',
			langs: 'languages'
		},

		vars: { },

		concat: {
			colorbox: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Colorbox.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-colorbox.js'
			},
			fancybox: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Fancybox.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-fancybox.js'
			},
			fancybox2: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Fancybox2.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-fancybox2.js'
			},
			fancybox3: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Fancybox3.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-fancybox3.js'
			},
			featherlight: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Featherlight.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-featherlight.js'
			},
			galleria: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Galleria.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-galleria.js'
			},
			imagelightbox: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_ImageLightbox.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-imagelightbox.js'
			},
			lightcase: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Lightcase.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-lightcase.js'
			},
			lightgallery: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Lightgallery.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-lightgallery.js'
			},
			magnific: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Magnific.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-magnific.js'
			},
			none: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-none.js'
			},
			photoswipe: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_PhotoSwipe.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-photoswipe.js'
			},
			prettyphoto: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_PrettyPhoto.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-prettyphoto.js'
			},
			strip: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Strip.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-strip.js'
			},
			swipebox: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Swipebox.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-swipebox.js'
			},
			thickbox: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.src %>/core/external.js',
					'<%= dirs.src %>/core/jq-start.tmpl',
					'<%= dirs.src %>/core/core.js',
					'<%= dirs.src %>/lightboxes/Lightbox.js',
					'<%= dirs.src %>/lightboxes/Lightbox_Thickbox.js',
					'<%= dirs.src %>/core/layouts.js',
					'<%= dirs.src %>/core/jq-end.tmpl'
				],
				dest: '<%= dirs.dest %>/photonic-thickbox.js'
			},

			no_jq_lightgallery: {
				options: {
					process: true
				},
				src: [
					'<%= dirs.no_jq_src %>/core/util.js',
					'<%= dirs.no_jq_src %>/core/external.js',
					'<%= dirs.no_jq_src %>/core/no-jq-start.tmpl',
					'<%= dirs.no_jq_src %>/core/core.js',
//					'<%= dirs.no_jq_src %>/lightboxes/Lightbox.js',
//					'<%= dirs.no_jq_src %>/lightboxes/Lightbox_Lightgallery.js',
//					'<%= dirs.no_jq_src %>/core/layouts.js',
					'<%= dirs.no_jq_src %>/core/no-jq-end.tmpl'
				],
				dest: '<%= dirs.no_jq_dest %>/photonic-lightgallery.js'
			}
		},

		uglify: {
			colorbox: {
				files: {
					'<%= dirs.dest %>/photonic-colorbox.min.js' : ['<%= dirs.dest %>/photonic-colorbox.js']
				}
			},
			fancybox: {
				files: {
					'<%= dirs.dest %>/photonic-fancybox.min.js' : ['<%= dirs.dest %>/photonic-fancybox.js']
				}
			},
			fancybox2: {
				files: {
					'<%= dirs.dest %>/photonic-fancybox2.min.js' : ['<%= dirs.dest %>/photonic-fancybox2.js']
				}
			},
			fancybox3: {
				files: {
					'<%= dirs.dest %>/photonic-fancybox3.min.js' : ['<%= dirs.dest %>/photonic-fancybox3.js']
				}
			},
			featherlight: {
				files: {
					'<%= dirs.dest %>/photonic-featherlight.min.js' : ['<%= dirs.dest %>/photonic-featherlight.js']
				}
			},
			galleria: {
				files: {
					'<%= dirs.dest %>/photonic-galleria.min.js' : ['<%= dirs.dest %>/photonic-galleria.js']
				}
			},
			imagelightbox: {
				files: {
					'<%= dirs.dest %>/photonic-imagelightbox.min.js' : ['<%= dirs.dest %>/photonic-imagelightbox.js']
				}
			},
			lightcase: {
				files: {
					'<%= dirs.dest %>/photonic-lightcase.min.js' : ['<%= dirs.dest %>/photonic-lightcase.js']
				}
			},
			lightgallery: {
				files: {
					'<%= dirs.dest %>/photonic-lightgallery.min.js' : ['<%= dirs.dest %>/photonic-lightgallery.js']
				}
			},
			magnific: {
				files: {
					'<%= dirs.dest %>/photonic-magnific.min.js' : ['<%= dirs.dest %>/photonic-magnific.js']
				}
			},
			none: {
				files: {
					'<%= dirs.dest %>/photonic-none.min.js' : ['<%= dirs.dest %>/photonic-none.js']
				}
			},
			photoswipe: {
				files: {
					'<%= dirs.dest %>/photonic-photoswipe.min.js' : ['<%= dirs.dest %>/photonic-photoswipe.js']
				}
			},
			prettyphoto: {
				files: {
					'<%= dirs.dest %>/photonic-prettyphoto.min.js' : ['<%= dirs.dest %>/photonic-prettyphoto.js']
				}
			},
			strip: {
				files: {
					'<%= dirs.dest %>/photonic-strip.min.js' : ['<%= dirs.dest %>/photonic-strip.js']
				}
			},
			swipebox: {
				files: {
					'<%= dirs.dest %>/photonic-swipebox.min.js' : ['<%= dirs.dest %>/photonic-swipebox.js']
				}
			},
			thickbox: {
				files: {
					'<%= dirs.dest %>/photonic-thickbox.min.js' : ['<%= dirs.dest %>/photonic-thickbox.js']
				}
			}
		},

		makepot: {
			target: {
				options: {
					type: 'wp-plugin',
					potFilename: 'photonic.pot',
					cwd: '<%= dirs.i18n_src %>',
					domainPath: '<%= dirs.langs %>'
				}
			}
		}
	});

	// Load plugins
	var cwd = process.cwd();
	process.chdir('../../../../..');
	grunt.loadNpmTasks('grunt-contrib-concat');
//	grunt.loadNpmTasks('grunt-jquery-ready');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-wp-i18n');
	process.chdir(cwd);

	// Tasks
	grunt.registerTask('default', [
		'concat:colorbox',
		'concat:fancybox',
		'concat:fancybox2',
		'concat:fancybox3',
		'concat:featherlight',
//		'concat:fluidbox',
		'concat:imagelightbox',
		'concat:galleria',
		'concat:lightcase',
		'concat:lightgallery',
		'concat:magnific',
		'concat:none',
		'concat:photoswipe',
		'concat:prettyphoto',
		'concat:strip',
		'concat:swipebox',
		'concat:thickbox',

		'concat:no_jq_lightgallery',

		'uglify:colorbox',
		'uglify:fancybox',
		'uglify:fancybox2',
		'uglify:fancybox3',
		'uglify:featherlight',
//		'uglify:fluidbox',
		'uglify:imagelightbox',
		'uglify:galleria',
		'uglify:lightcase',
		'uglify:lightgallery',
		'uglify:magnific',
		'uglify:none',
		'uglify:photoswipe',
		'uglify:prettyphoto',
		'uglify:strip',
		'uglify:swipebox',
		'uglify:thickbox',

		'makepot:target'
	]);
};