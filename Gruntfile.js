module.exports = function (grunt) {

    // load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    // 1. All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            dist: {
                src: [
                    'node_modules/barba.js/dist/barba.min.js',
                    'node_modules/animejs/anime.min.js',
                    'node_modules/js-cookie/src/js.cookie.js',
                    'node_modules/pace-js/pace.min.js',
                    'node_modules/typed.js/lib/typed.min.js',
                    // 'node_modules/imagesloaded/imagesloaded.pkgd.min.js',
                    // 'node_modules/flickity/dist/flickity.pkgd.min.js',
                    'js/pages/*.js',
                    'js/components/*.js',
                    'js/app.js'
                ],
                dest: 'js/build/production.js'
            }
        },
        uglify: {
            dist: {
                src: 'js/build/production.js',
                dest: 'js/build/production.min.js'
            }
        },
        sass: {
            dist: {
                options: {
                    style: 'compressed',
                    loadPath: ['scss/style.scss']
                },
                files: {
                    'css/style.css': 'scss/style.scss'
                }
            }
        },
        autoprefixer: {
            dist: {
                files: {
                    'css/style.css': 'css/style.css'
                }
            }
        },
        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'css',
                    src: ['*.css', '!*.min.css'],
                    dest: 'css',
                    ext: '.min.css'
                }]
            }
        },
        imagemin: {
            dynamic: {
                options: {
                    optimizationLevel: 3,
                    progressive: true,
                    svgoPlugins: [{removeViewBox: false}]
                },
                files: [{
                    expand: true,
                    cwd: 'assets/',
                    src: ['**/*.{png,jpg,gif,svg,jpeg}', '*.{png,jpg,gif,svg,jpeg}'],
                    dest: 'images/'
                }]
            }
        },
        watch: {
            scripts: {
                files: ['js/*.js', 'js/components/*.js', 'js/pages/*.js'],
                tasks: ['concat', 'uglify'],
                options: {
                    spawn: false
                }
            },
            css: {
                files: ['scss/*.scss', 'scss/components/*.scss', 'scss/pages/*.scss'],
                tasks: ['sass'],
                options: {
                    spawn: false
                }
            },
            styles: {
                files: ['css/style.css'],
                tasks: ['autoprefixer']
            }
        }

    });

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('build', ['concat', 'uglify', 'sass', 'autoprefixer', 'cssmin', 'imagemin']);
    grunt.registerTask('dev', ['concat', 'sass', 'autoprefixer']);
    grunt.registerTask('default', ['dev', 'watch']);

};