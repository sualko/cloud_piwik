/* global module:false */
module.exports = function(grunt) {

   grunt.initConfig({
      jshint: {
         options: {
            jshintrc: '.jshintrc'
         },
         gruntfile: {
            src: 'Gruntfile.js'
         },
         files: ['js/*.js', '!js/piwik.js']
      },
      jsbeautifier: {
         files: ['js/*.js', '!js/piwik.js'],
         options: {
            config: '.jsbeautifyrc'
         }
      },
   });
   
   grunt.loadNpmTasks('grunt-contrib-jshint');
   grunt.loadNpmTasks('grunt-jsbeautifier');
   
   grunt.registerTask('default', ['jshint', 'jsbeautifier']);
};
