/* jshint node:true */
module.exports = function ( grunt ) {
    'use strict';

    grunt.initConfig( {
        // setting folder templates
        dirs: {
            css: 'assets/css',
            fonts: 'assets/fonts',
            images: 'assets/images',
            js: 'assets/js',
            lang: 'languages'
        },

        // compile all sass files
        sass: {
            dist: {
                options: {
                    // These paths are searched for @imports
                    paths: [ '<%= dirs.css %>/' ]
                },
                files: [ {
                    expand: true,
                    cwd: '<%= dirs.css %>/scss/',
                    src: [
                        '*.scss',
                        '!mixins.scss'
                    ],
                    dest: '<%= dirs.css %>/',
                    ext: '.css'
                } ]
            }
        },

        // Minify all .css files.
        cssmin: {
            minify: {
                expand: true,
                cwd: '<%= dirs.css %>/',
                src: [ '*.css' ],
                dest: '<%= dirs.css %>/',
                ext: '.css'
            }
        },

        // Minify .js files.
        uglify: {
            options: {
                preserveComments: 'none'
            },
            jsfiles: {
                files: [ {
                    expand: true,
                    cwd: '<%= dirs.js %>/',
                    src: [
                        '*.js',
                        '!*.min.js',
                        '!Gruntfile.js',
                    ],
                    dest: '<%= dirs.js %>/',
                    ext: '.min.js'
                } ]
            }
        },

        // Watch changes for assets
        watch: {
            sass: {
                files: [ '<%= dirs.css %>/scss/*.scss' ],
                tasks: [ 'sass', 'cssmin' ]
            },
            js: {
                files: [
                    '<%= dirs.js %>/*js',
                    '!<%= dirs.js %>/*.min.js'
                ],
                tasks: [ 'uglify' ]
            }
        },

        // Generate POT files.
        makepot: {
            options: {
                type: 'wp-plugin',
                domainPath: 'languages',
                potHeaders: {
                    'report-msgid-bugs-to': 'https://github.com/barrykooij/wp-notification-center/issues',
                    'language-team': 'LANGUAGE <EMAIL@ADDRESS>'
                }
            },
            frontend: {
                options: {
                    potFilename: 'wp-notification-center.pot',
                    exclude: [
                        'node_modules/.*',
                        'tests/.*',
                        'tmp/.*'
                    ],
                    processPot: function ( pot ) {
                        return pot;
                    }
                }
            }
        },

        po2mo: {
            files: {
                src: '<%= dirs.lang %>/*.po',
                expand: true
            }
        }

    } );

    // Load NPM tasks to be used here
    grunt.loadNpmTasks( 'grunt-shell' );
    grunt.loadNpmTasks( 'grunt-sass' );
    grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
    grunt.loadNpmTasks( 'grunt-contrib-uglify' );
    grunt.loadNpmTasks( 'grunt-contrib-watch' );
    grunt.loadNpmTasks( 'grunt-wp-i18n' );
    grunt.loadNpmTasks( 'grunt-checktextdomain' );
    grunt.loadNpmTasks( 'grunt-po2mo' );

    // Register tasks
    grunt.registerTask( 'default', [
        'sass',
        'cssmin',
        'uglify'
    ] );

    // Just an alias for pot file generation
    grunt.registerTask( 'pot', [
        'makepot'
    ] );

};