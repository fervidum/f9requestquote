module.exports = function (grunt) {

  'use strict';

  // Force use of Unix newlines
  grunt.util.linefeed = '\n';

  // Project configuration.
  grunt.initConfig({
    // Meta data
    pkg: grunt.file.readJSON('package.json'),

    makepot: {
      target: {
        options: {
          cwd:         '.',
          domainPath:  'i18n/languages',
          type:        'wp-plugin',
          mainFile:    'f9requestquote.php',
          potFilename: 'f9requestquote.pot'
        }
      }
    }

  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-wp-i18n');

  grunt.registerTask('default', ['makepot']);

};
