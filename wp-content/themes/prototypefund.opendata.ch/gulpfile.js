var gulp = require('gulp'),
    compass = require('gulp-compass'),
    notify = require("gulp-notify"),
    livereload = require('gulp-livereload'),
    usemin = require('gulp-usemin'),
    replace = require('gulp-replace'),
    uglify = require('gulp-uglifyjs');
    autoprefixer = require('gulp-autoprefixer'),
    less = require('gulp-less'),
    svgSprite = require('gulp-svg-sprite');


var config = {
    base_path: './library/'
}


// JS
var libs = [
    config.base_path +'js/scripts.js'
    ,config.base_path +'js/libs/jquery.fitvids.js'
    ,config.base_path +'js/libs/slick.min.js'
    ,config.base_path +'js/libs/iframeResizer.min.js'
    ,config.base_path +'js/libs/swiper.jquery.min.js'
    ,config.base_path +'js/libs/slidebars.min.js'
    ,config.base_path +'js/libs/hammer.min.js'
    ,config.base_path +'js/libs/imagesloaded.pkgd.min.js'
    ,config.base_path +'js/libs/isotope.pkgd.min.js'
    ,config.base_path +'js/libs/jquery.fixer.js'
    ,config.base_path +'js/libs/sticky.min.js'
    ,config.base_path +'js/utils/MailchimpForms.js'
    ,config.base_path +'js/libs/logger.min.js'
    ,config.base_path +'js/libs/lazyload.min.js'
    ,config.base_path +'js/libs/greensock/TweenMax.min.js'
    ,config.base_path +'js/libs/greensock/plugins/ScrollToPlugin.min.js'
    ,config.base_path +'js/libs/scrollmagic/ScrollMagic.min.js'
    ,config.base_path +'js/libs/scrollmagic/animation.gsap.min.js'
    ,config.base_path +'js/utils/CookieManager.js'
    ,config.base_path +'js/app/PaperView.js'
    ,config.base_path +'js/app/ProjectsFilter.js'
    ,config.base_path +'js/app/CouplesView.js'
    ,config.base_path +'js/utils/TwitterShareController.js'
    ,config.base_path +'js/app/pages/NewsPage.js'
    ,config.base_path +'js/app/pages/ProjectsPage.js'
    ,config.base_path +'js/app/AnimationController.js'
    ,config.base_path +'js/utils/VideoPoster.js'
    ,config.base_path +'js/app/ChartsManager.js'
    ,config.base_path +'js/app/Controller.js'
];

gulp.task('uglify', function() {
    gulp.src(libs)
        .pipe(uglify('app.min.js'))
        .pipe(gulp.dest(config.base_path + 'js/'))
});


// SVG Spriting
sprite_config       = {
    "mode": {
        "css": {
            "render": {
                "scss": true ,
                "less": true
            },
            "dest" : "./scss",
            "layout":"diagonal"
        }
    }
};

gulp.task('create-sprite', function() {
    gulp.src(config.base_path +'svgs/*.svg')
        .pipe(svgSprite(sprite_config))
        .pipe(gulp.dest('./library/'));
});

gulp.task('copy-sprite',['create-sprite'],function(){
    gulp.src( './library/scss/svg/*.svg')
        .pipe(gulp.dest( './library/css/svg'));
});

gulp.task('compass', function() {
    gulp.src(config.base_path + 'scss/**/*.scss')
        .pipe(compass({
            config_file: './library/scss/config.rb',
            css: config.base_path + 'css',
            sass: config.base_path +'scss',
            font: config.base_path +'fonts',
            image: config.base_path +'images'
        })
            .on("error", notify.onError(function (error) {
                return "Error: " + error.message;
            }))
    )
        .pipe(autoprefixer({
            browsers: ['last 2 versions','ie 9','ie 8']
        }))
        .pipe(gulp.dest(config.base_path + 'css'))
        //.pipe(notify("Done."));
});


gulp.task('watch', function() {
    var server = livereload.listen();
    gulp.watch(config.base_path + 'scss/**/*.scss', ['compass']);
    gulp.watch(config.base_path + 'css/**/*.css').on('change',livereload.changed);
});

gulp.task('default', ['create-sprite', 'copy-sprite', 'uglify', 'watch']);
