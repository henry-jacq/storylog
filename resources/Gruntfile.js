module.exports = function (grunt) {
  // Do grunt-related things in here

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
        sourceMap: true,
        banner: "/* Processed by Grunt on " + datetime + " */\n\n\n",
      },
      css: {
        src: ["src/css/**/*.css"],
        dest: "dist/app.css",
      },
      js: {
        src: ["src/js/**/*.js"],
        dest: "dist/app.js",
      },
      scss: {
        src: ["src/scss/**/*.scss"],
        dest: "dist/style.scss",
      },
    },
    cssmin: {
      options: {
        mergeIntoShorthands: false,
        roundingPrecision: -1,
        sourceMap: true,
      },
      css: {
        files: {
          "../public/css/app.min.css": ["dist/app.css"],
        },
      },
      scss: {
        files: {
          "../public/css/style.min.css": ["dist/style.css"],
        },
      },
    },
    sass: {
      compile_scss: {
        options: {
          style: "expanded",
        },
        files: {
          "dist/style.css": ["dist/style.scss"],
        },
      },
    },
    uglify: {
      minify: {
        options: {
          sourceMap: true,
        },
        files: {
          "../public/js/app.min.js": ["dist/app.js"],
        },
      },
    },
    copy: {
      jquery: {
        expand: false,
        src: "../node_modules/jquery/dist/jquery.js",
        dest: "../public/js/jquery/jquery.js",
      },
      popperjs_min: {
      expand: false,
        src: "../node_modules/@popperjs/core/dist/umd/popper.min.js",
        dest: "../public/js/bootstrap/popper.min.js",
      },
      popperjs_min_map: {
        expand: false,
        src: "../node_modules/@popperjs/core/dist/umd/popper.min.js.map",
        dest: "../public/js/bootstrap/popper.min.js.map",
      },
      bootstrap_js_min: {
        expand: false,
        src: "../node_modules/bootstrap/dist/js/bootstrap.min.js",
        dest: "../public/js/bootstrap/bootstrap.min.js",
      },
      bootstrap_js_min_map: {
        expand: false,
        src: "../node_modules/bootstrap/dist/js/bootstrap.min.js.map",
        dest: "../public/js/bootstrap/bootstrap.min.js.map",
      },
      bootstrap_css_min: {
        expand: false,
        src: "../node_modules/bootstrap/dist/css/bootstrap.min.css",
        dest: "../public/css/bootstrap.min.css",
      },
      bootstrap_css_min_map: {
        expand: false,
        src: "../node_modules/bootstrap/dist/css/bootstrap.min.css.map",
        dest: "../public/css/bootstrap.min.css.map",
      },
    },

    obfuscator: {
      options: {
        banner: "// Obfuscated by grunt-contrib-obfuscator @" + datetime + "\n",
        debugProtection: true,
        debugProtectionInterval: true,
        domainLock: ["storylog.selfmade.one"],
      },
      obfuscate: {
        options: {
          // options for each sub task
        },
        files: {
          "../public/js/app.ofs.js": ["src/js/**/**.js"],
        },
      },
    },
    watch: {
      css: {
        files: ["src/css/**/*.css"],
        tasks: ["concat:css", "cssmin"],
        options: {
          spawn: false,
        },
      },
      js: {
        files: ["src/js/**/*.js"],
        tasks: ["concat:js", "uglify", "obfuscator"],
        options: {
          spawn: false,
        },
      },
      scss: {
        files: ["src/scss/**/*.scss"],
        tasks: ["concat:scss", "sass", "cssmin"],
        options: {
          spawn: false,
        },
      },
    },
  });

  grunt.loadNpmTasks("grunt-contrib-concat");
  grunt.loadNpmTasks("grunt-contrib-copy");
  grunt.loadNpmTasks("grunt-contrib-cssmin");
  grunt.loadNpmTasks("grunt-contrib-obfuscator");
  grunt.loadNpmTasks("grunt-contrib-sass");
  grunt.loadNpmTasks("grunt-contrib-uglify");
  grunt.loadNpmTasks("grunt-contrib-watch");
  /** Default Grunt Tasks
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
