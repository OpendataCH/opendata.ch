"use strict";

// Load plugins
const autoprefixer = require("autoprefixer");
const browsersync = require("browser-sync").create();
const cp = require("child_process");
const cssnano = require("cssnano");
const del = require("del");
const gulp = require("gulp");
const imagemin = require("gulp-imagemin");
const newer = require("gulp-newer");
const plumber = require("gulp-plumber");
const postcss = require("gulp-postcss");
const uglify = require("gulp-uglify");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
const globbing = require("gulp-css-globbing");
const concat = require("gulp-concat");
const svgSprite = require("gulp-svg-sprite");

const sourcemaps = require("gulp-sourcemaps");
const source = require("vinyl-source-stream");
const buffer = require("vinyl-buffer");
const rollup = require("@rollup/stream");

// *Optional* Depends on what JS features you want vs what browsers you need to support
// *Not needed* for basic ES6 module import syntax support
const babel = require("@rollup/plugin-babel");

// Add support for require() syntax
const commonjs = require("@rollup/plugin-commonjs");

// Add support for importing from node_modules folder like import x from 'module-name'
const { nodeResolve } = require("@rollup/plugin-node-resolve");

// Cache needs to be initialized outside of the Gulp task
let cache;

const plugins = [
    nodeResolve({
        mainFields: ["module"]
    }),
    commonjs({
        include: "node_modules/**"
    }),
    babel.babel({ babelHelpers: "bundled" })
];

function lib() {
    return (
        rollup({
            // Point to the entry file
            input: "./library/js/app.js",

            // Apply plugins
            plugins: plugins,

            // Use cache for better performance
            cache: cache,

            // Note: these options are placed at the root level in older versions of Rollup
            output: {
                // Output bundle is intended for use in browsers
                // (iife = "Immediately Invoked Function Expression")
                format: "iife",

                // Show source code when debugging in browser
                sourcemap: true
            }
        })
            .on("bundle", function (bundle) {
                // Update cache data after every bundle is created
                cache = bundle;
            })
            // Name of the output file.
            .pipe(source("app.js"))
            .pipe(buffer())

            // The use of sourcemaps here might not be necessary,
            // Gulp 4 has some native sourcemap support built in
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(sourcemaps.write("."))

            // Where to send the output file
            .pipe(gulp.dest("./dist/js/"))
            .pipe(browsersync.stream())
    );
}

const onError = (err) => {
    console.log(err);
};

// BrowserSync
function browserSync(done) {
    browsersync.init({
        proxy: "opendata.local"
    });
    done();
}

// BrowserSync Reload
function browserSyncReload(done) {
    browsersync.reload();
    done();
}

// Clean assets
function clean() {
    return del(["./dist"]);
}

// CSS task
function css() {
    return gulp
        .src("./library/scss/**/*.scss")
        .pipe(globbing({ extensions: [".scss"] }))
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass({ outputStyle: "expanded" }).on("error", sass.logError))
        .pipe(gulp.dest("./library/css/"))
        .pipe(rename({ suffix: ".min", basename: "main", extname: ".css" }))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(gulp.dest("./dist/css/"))
        .pipe(browsersync.stream());
}

// Copy jQuery
function wordpressAssets() {
    return gulp.src(["./library/js/vendor/jquery.min.js"]).pipe(gulp.dest("./dist/js/"));
}

// Copy Fonts
function fonts() {
    return gulp.src(["./library/fonts/*.{eot,ttf,woff,woff2}"]).pipe(gulp.dest("./dist/fonts/"));
}
const config = {
    mode: {
        symbol: {
            dest: ".",
            inline: true,
            sprite: "svgsprite.php"
        },
        svg: {
            xmlDeclaration: false
        }
    }
};
function sprite() {
    return gulp
        .src("./library/icons/**/*.svg")
        .pipe(
            imagemin([
                imagemin.svgo({
                    plugins: [
                        {
                            removeViewBox: false,
                            collapseGroups: true
                        },
                        {
                            convertColors: {
                                currentColor: true
                            }
                        }
                    ]
                })
            ])
        )
        .pipe(svgSprite(config))
        .pipe(gulp.dest("./templates/"));
}
// Optimize Icons
function icons() {
    return gulp
        .src("./library/icons/**/*.svg")
        .pipe(newer("./dist/icons/**/*"))
        .pipe(
            imagemin([
                imagemin.svgo({
                    plugins: [
                        {
                            removeViewBox: false,
                            collapseGroups: true
                        },
                        {
                            convertColors: {
                                currentColor: false
                            }
                        }
                    ]
                })
            ])
        )
        .pipe(gulp.dest("./dist/icons/"));
}

// Optimize Images
function images() {
    return gulp
        .src(["./library/img/**/*.{gif,jpg,png,svg}", "./library/icons/**/*.{svg}"])
        .pipe(newer("./dist/img/*"))
        .pipe(
            imagemin([
                imagemin.gifsicle({ interlaced: true }),
                imagemin.jpegtran({ progressive: true }),
                imagemin.optipng({ optimizationLevel: 5 }),
                imagemin.svgo({
                    plugins: [
                        {
                            removeViewBox: false,
                            collapseGroups: true
                        }
                    ]
                })
            ])
        )
        .pipe(gulp.dest("./dist/img/"));
}

// Watch files
function watchFiles() {
    gulp.watch("./library/scss/**/*", css);
    gulp.watch("./library/js/**/*", gulp.series(lib));
    gulp.watch("./library/img/**/*.{gif,jpg,png,svg}", images);
    gulp.watch("./library/icons/**/*.svg", sprite);

    gulp.watch(["./*", "./blocks/**/*", "./templates/**/*", "./functions/*", "./pages/*"], gulp.series(browserSyncReload));
}

// define tasks
const build = gulp.series(clean, gulp.parallel(fonts, wordpressAssets), gulp.parallel(css, lib, images, sprite));
const watch = gulp.parallel(build, watchFiles, browserSync);

// export tasks
exports.images = images;
exports.icons = icons;
exports.sprite = sprite;
exports.fonts = fonts;
exports.wordpressAssets = wordpressAssets;
exports.css = css;
exports.clean = clean;
exports.lib = lib;
exports.build = build;
exports.watch = watch;
exports.default = build;
