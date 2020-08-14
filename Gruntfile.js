/* global module:false */
module.exports = function(grunt) {

   grunt.initConfig({
      meta: {
         app: grunt.file.readJSON('package.json'),
         banner: grunt.file.read('banner.js')
      },
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
         files: ['Gruntfile.js', 'js/*.js', '!js/piwik.js'],
         options: {
            config: '.jsbeautifyrc'
         }
      },
      clean: ['build/'],
      copy: {
         main: {
            files: [{
               expand: true,
               src: ['appinfo/**', 'css/**', 'js/**', 'templates/**', 'img/**', 'lib/**', 'LICENSE'],
               dest: 'build/'
            }]
         }
      },
      usebanner: {
         dist: {
            options: {
               position: 'top',
               banner: '<%= meta.banner %>'
            },
            files: {
               src: ['build/js/*.js', '!build/js/piwik.js']
            }
         }
      },
      replace: {
         info: {
            src: ['build/appinfo/info.xml', 'appinfo/info.xml'],
            overwrite: true,
            replacements: [{
               from: /<version>[\d.]+<\/version>/,
               to: "<version><%= meta.app.version %></version>"
            }]
         },
         version: {
            src: ['build/appinfo/version', 'appinfo/version'],
            overwrite: true,
            replacements: [{
               from: /[\d.]+/,
               to: "<%= meta.app.version %>"
            }]
         }
      },
      uglify: {
         main: {
            options: {
               mangle: false,
               sourceMap: true,
               preserveComments: 'some'
            },
            files: {
               'build/js/settings/admin.min.js': ['js/settings/admin.js'],
            }
         }
      },
      compress: {
         main: {
            options: {
               archive: "archives/cloud_piwik-<%= meta.app.version %>.tar.gz",
               mode: 'tgz'
            },
            files: [{
               src: ['**'],
               expand: true,
               dest: 'piwik/',
               cwd: 'build/'
            }]
         }
      },
      exec: {
         createNextcloudSignature: {
            command: 'openssl dgst -sha512 -sign ' +
               '~/.nextcloud/certificates/piwik.key ' +
               'archives/cloud_piwik-<%= meta.app.version %>.tar.gz | openssl base64 > ' +
               'archives/cloud_piwik-<%= meta.app.version %>.tar.gz.ncsig'
         },
         createGPGSignature: {
            command: 'gpg --yes --detach-sign "archives/cloud_piwik-<%= meta.app.version %>.tar.gz"'
         },
         createGPGArmorSignature: {
            command: 'gpg --yes --detach-sign --armor "archives/cloud_piwik-<%= meta.app.version %>.tar.gz"'
         }
      }
   });

   grunt.loadNpmTasks('grunt-contrib-jshint');
   grunt.loadNpmTasks('grunt-contrib-copy');
   grunt.loadNpmTasks('grunt-contrib-clean');
   grunt.loadNpmTasks('grunt-contrib-uglify');
   grunt.loadNpmTasks('grunt-contrib-compress');
   grunt.loadNpmTasks('grunt-jsbeautifier');
   grunt.loadNpmTasks('grunt-banner');
   grunt.loadNpmTasks('grunt-text-replace');
   grunt.loadNpmTasks('grunt-exec');

   grunt.registerTask('default', ['jshint', 'jsbeautifier']);

   grunt.registerTask('build', ['jshint', 'jsbeautifier', 'clean', 'copy', 'usebanner']);
   grunt.registerTask('build:release', ['build', 'replace', 'uglify', 'compress']);

   grunt.registerTask('sign:release', ['exec:createNextcloudSignature', 'exec:createGPGSignature', 'exec:createGPGArmorSignature']);
};
