'use strict';
module.exports = function(grunt) {

  grunt.initConfig({

    less: {
      dist: {
        files: {
          'style.css': [
            'style.less'
          ]
        },
        options: {
          compress: false,
          sourceMap: false,
        }
      }
    },

    watch: {
      less: {
        files: [
          '*.less',
          'less/*.less'
        ],
        tasks: [
          'less',
        ],
        options: {
          livereload: true
        }
      },
    },
    
    clean: {
      dist: [
        'style.css',
      ]
    }
  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');

  // Register tasks
  grunt.registerTask('default', [
    'clean',
    'less',
  ]);
  grunt.registerTask('dev', [
    'watch'
  ]);

};