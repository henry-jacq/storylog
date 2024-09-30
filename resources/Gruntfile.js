module.exports = function (grunt) {
  var currentdate = new Date();
  var datetime =
    currentdate.getDate() +
    "/" +
    (currentdate.getMonth() + 1) +
    "/" +
    currentdate.getFullYear() +
    " @" +
    currentdate.getHours() +
    ":" +
    currentdate.getMinutes() +
    ":" +
    currentdate.getSeconds();

  // Project configuration.
  grunt.initConfig({
    concat: {
      options: {
        separator: "\n",
        banner: "/* Processed by Grunt on " + datetime + " */\n",
      },
      auth_css: {
        src: ["src/css/auth/**/*.css"],
        dest: "dist/auth.css",
      },
      user_css: {
        src: ["src/css/user/**/*.css"],
        dest: "dist/app.css",
      },
      js_core: {
        src: ["src/js/libs/**/*.js"],
        dest: "dist/core.js",
      },
      js_app: {
        src: ["src/js/templates/**/*.js"],
        dest: "dist/app.js",
      },
      scss: {
        src: ["src/scss/**/*.scss"],
        dest: "dist/bootstrap.scss",
      },
    },
    cssmin: {
      options: {
        separator: "\n",
        banner: "/* Processed by Grunt on " + datetime + " */\n",
        mergeIntoShorthands: false,
        roundingPrecision: -1,
        sourceMap: true,
      },
      auth_css: {
        files: {
          "../storage/static/css/auth.min.css": ["dist/auth.css"],
        },
      },
      user_css: {
        files: {
          "../storage/static/css/app.min.css": ["dist/app.css"],
        },
      },
      scss: {
        files: {
          "../storage/static/css/bootstrap.min.css": ["dist/bootstrap.css"],
        },
      },
    },
    sass: {
      compile_scss: {
        options: {
          style: "expanded",
          loadPath: ["../node_modules/bootstrap/scss"],
        },
        files: {
          "dist/bootstrap.css": ["dist/bootstrap.scss"],
        },
      },
    },
    uglify: {
      minify: {
        options: {
          sourceMap: true,
        },
        files: {
          "../storage/static/js/app.min.js": ["dist/app.js"],
          "../storage/static/js/core.min.js": ["dist/core.js"],
        },
      },
    },
    copy: {
      jquery_min: {
        expand: false,
        src: "../node_modules/jquery/dist/jquery.min.js",
        dest: "../storage/static/js/vendor/jquery.min.js",
      },
      jquery_min_map: {
        expand: false,
        src: "../node_modules/jquery/dist/jquery.min.map",
        dest: "../storage/static/js/vendor/jquery.min.js.map",
      },
      popperjs_min: {
        expand: false,
        src: "../node_modules/@popperjs/core/dist/umd/popper.min.js",
        dest: "../storage/static/js/vendor/popper.min.js",
      },
      popperjs_min_map: {
        expand: false,
        src: "../node_modules/@popperjs/core/dist/umd/popper.min.js.map",
        dest: "../storage/static/js/vendor/popper.min.js.map",
      },
      bootstrap_js_min: {
        expand: false,
        src: "../node_modules/bootstrap/dist/js/bootstrap.min.js",
        dest: "../storage/static/js/vendor/bootstrap.min.js",
      },
      bootstrap_js_min_map: {
        expand: false,
        src: "../node_modules/bootstrap/dist/js/bootstrap.min.js.map",
        dest: "../storage/static/js/vendor/bootstrap.min.js.map",
      },
      // bootstrap_css_min: {
      //     expand: false,
      //     src: "../node_modules/bootstrap/dist/css/bootstrap.min.css",
      //     dest: "../storage/static/css/bootstrap.min.css",
      // },
      // bootstrap_css_min_map: {
      //     expand: false,
      //     src: "../node_modules/bootstrap/dist/css/bootstrap.min.css.map",
      //     dest: "../storage/static/css/bootstrap.min.css.map",
      // },
    },

    obfuscator: {
      options: {
        banner: "// Obfuscated by grunt-contrib-obfuscator @" + datetime + "\n",
        debugProtection: true,
        debugProtectionInterval: true,
        domainLock: ["storylog.local"],
      },
      obfuscate: {
        options: {
          // options for each sub task
        },
        files: {
          "../storage/static/js/app.ofs.js": ["src/js/templates/**/**.js"],
          "../storage/static/js/core.ofs.js": ["src/js/libs/**/**.js"],
        },
      },
    },
    watch: {
      auth_css: {
        files: ["src/css/auth/**/*.css"],
        tasks: ["concat:css", "cssmin:auth_css"],
        options: {
          spawn: false,
        },
      },
      user_css: {
        files: ["src/css/user/**/*.css"],
        tasks: ["concat:css", "cssmin:user_css"],
        options: {
          spawn: false,
        },
      },
      js_core: {
        files: ["src/js/libs/**/*.js"],
        tasks: ["concat:js_core", "uglify", "obfuscator"],
        options: {
          spawn: false,
        },
      },
      js_app: {
        files: ["src/js/templates/**/*.js"],
        tasks: ["concat:js_app", "uglify", "obfuscator"],
        options: {
          spawn: false,
        },
      },
      scss: {
        files: ["src/scss/**/*.scss"],
        tasks: ["concat:scss", "sass", "cssmin:scss"],
        options: {
          spawn: false,
        },
      },
    },
  });

  grunt.loadNpmTasks("grunt-contrib-copy");
  grunt.loadNpmTasks("grunt-contrib-concat");
  grunt.loadNpmTasks("grunt-contrib-sass");
  grunt.loadNpmTasks("grunt-contrib-cssmin");
  grunt.loadNpmTasks("grunt-contrib-uglify");
  grunt.loadNpmTasks("grunt-contrib-obfuscator");
  grunt.loadNpmTasks("grunt-contrib-watch");
  /**
   * Default Grunt Tasks
   * Copy files to public folder
   * Concatenate files into one file
   * Minify CSS
   * Compile and minify scss
   * Uglify javascript
   * Obfuscate javascript
   */

  grunt.registerTask("default", [
    "copy",
    "concat",
    "cssmin:css",
    "sass",
    "cssmin:scss",
    "uglify",
    "obfuscator",
    "watch",
  ]);
};
