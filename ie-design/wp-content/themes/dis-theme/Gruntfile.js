'use strict';
module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {
		    options: {
		        separator: '\r\n'
		    },
		    dist: {
		        src: ['js/bootstrap/*.js', 'js/plugins/*.js', 'js/bootstrap/affix.js', 'js/pages/*.js'],
		        dest: 'js/alljs.js'
		    }
		},
		uglify: {
		    options: {
		        banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
		    },
		    dist: {
		         files: {
		              'js/alljs.min.js': ['<%= concat.dist.dest %>']
			 }
		    }
		}
		//jshint: {
		//     files: ['gruntfile.js', 'assets/js/*.js', 'assets/js/modules/*.js'],
		//     options: {
		//         globals: {
		//              jQuery: true,
		//              console: true,
		//              module: true
		//         }
		//     }
		//}

    });

    grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.registerTask('default', ['concat', 'uglify']);
	//grunt.loadNpmTasks('grunt-contrib-jshint');
	//grunt.registerTask('default', ['concat', 'uglify', 'jshint']);
};