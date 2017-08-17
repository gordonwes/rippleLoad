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
                    //'node_modules/whatwg-fetch/fetch.js',
                    //'node_modules/masonry-layout/dist/masonry.pkgd.min.js',
                    'node_modules/imagesloaded/imagesloaded.pkgd.min.js',
                    //'node_modules/infinite-scroll/dist/infinite-scroll.pkgd.min.js',
                    //'node_modules/isotope-layout/dist/isotope.pkgd.min.js',
                    // 'node_modules/flickity/dist/flickity.pkgd.min.js',
                    'js/components/*.js',
                    'js/app.js'
                ],
                dest: 'js/build/production.js'
            },
            admin: {
                src: [
                    'js/admin.js'
                ],
                dest: 'js/build/admin.js'
            },
            login: {
                src: [
                    'js/login.js'
                ],
                dest: 'js/build/login.js'
            }
        },
        uglify: {
            dist: {
                src: 'js/build/production.js',
                dest: 'js/build/production.min.js'
            },
            admin: {
                src: 'js/build/admin.js',
                dest: 'js/build/admin.min.js'
            },
            login: {
                src: 'js/build/login.js',
                dest: 'js/build/login.min.js'
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
            }, 
            admin: {
                options: {
                    style: 'compressed',
                    loadPath: ['scss/admin.scss']
                },
                files: {
                    'css/admin.css': 'scss/admin.scss'
                }
            },
            login: {
                options: {
                    style: 'compressed',
                    loadPath: ['scss/login.scss']
                },
                files: {
                    'css/login.css': 'scss/login.scss'
                }
            },
            other: {
                options: {
                    style: 'compressed',
                    loadPath: ['scss/dev.scss']
                },
                files: {
                    'css/dev.css': 'scss/dev.scss'
                }
            }
        },
        autoprefixer: {
            dist: {
                files: {
                    'css/style.css': 'css/style.css'
                }
            },
            admin: {
                files: {
                    'css/admin.css': 'css/admin.css'
                }
            },
            login: {
                files: {
                    'css/login.css': 'css/login.css'
                }
            },
            other: {
                files: {
                    'css/dev.css': 'css/dev.css'
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
        clean: ['app/'],
        htmlmin: {
            dist: {
                options: {
                    removeComments: true,
                    collapseWhitespace: true,
                    ignoreCustomFragments: [ /<%[\s\S]*?%>/, /<\?[\s\S]*?(\?>|$)/ ],
                    html5: true
                },
                files: [{
                    expand: true,
                    cwd: 'src/',
                    src: ['**/*.php', '*.php'],
                    dest: 'app'
                }]
            }
        },
        watch: {
            html: {
                files: ['src/*.php', 'src/fragments/*.php', 'src/projects/*.php'],
                tasks: ['htmlmin'],
                options: {
                    removeComments: true,
                    collapseWhitespace: true,
                    ignoreCustomFragments: [ /<%[\s\S]*?%>/, /<\?[\s\S]*?(\?>|$)/ ],
                    html5: true
                }
            },
            scripts: {
                files: ['js/*.js', 'js/components/*.js'],
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
    grunt.registerTask('build', ['concat', 'uglify', 'sass', 'autoprefixer', 'cssmin', 'imagemin', 'clean', 'htmlmin']);
    grunt.registerTask('dev', ['concat', 'sass', 'autoprefixer', 'clean', 'htmlmin']);
    grunt.registerTask('default', ['dev', 'watch']);

};