require('dotenv').config({path: './.env'});

var babel = require('gulp-babel');
var babelify = require('babelify');
var browserify = require('browserify');
var browserSync = require('browser-sync').create();
var buffer = require('vinyl-buffer');
var concat = require('gulp-concat');
var gulp = require('gulp');
var plumber = require('gulp-plumber');
var reload = browserSync.reload;
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var source = require('vinyl-source-stream');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var watch = require('gulp-watch');

/**
 * Paths
 */
var res = {
  assets: './resources/assets/',
  scss: './resources/assets/scss/',
  fonts: './resources/assets/fonts/',
  images: './resources/assets/images/',
  js: './resources/assets/js/',
  vendor: './resources/assets/js/vendor/',
  redux: './resources/assets/js/redux/'
};

var dist = {
  css: './public/css/',
  fonts: './public/fonts/',
  images: './public/images/',
  js: './public/js/',
  redux: './public/js/'
}

var staticRes = [res.fonts + '**/*', res.images + '**/*'];


/**
 * Compiles scss files
 */
gulp.task('sass', function() {
  gulp.src(res.scss + 'main.scss')
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'compressed' }))
    .pipe(rename({suffix: '.min'}))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(dist.css));
});

gulp.task('admin-sass', function() {
  gulp.src(res.scss + 'admin.scss')
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'compressed' }))
    .pipe(rename({suffix: '.min'}))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(dist.css));
});

// Compiles js files
gulp.task('js', function() {
  gulp.src(res.js + 'main.js')
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(babel({
      presets: ['es2015']
    }))
    .pipe(concat('main.min.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(dist.js));
});

// Compiles vendor js files
gulp.task('vendor', function(){
  gulp.src([res.vendor + 'jquery-3.1.1.min.js', res.vendor + '**/*.js'])
      .pipe(plumber())
      .pipe(sourcemaps.init())
      .pipe(concat('vendor.min.js'))
      .pipe(uglify())
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest(dist.js));
});

// Compiles Redux files
gulp.task('redux', function() {
  // process.env.NODE_ENV = 'production';
  browserify(res.redux + 'index.js')
    .transform(babelify.configure({
        presets: ['es2015', 'react']
    }))
    .bundle()
    .on('error', function(err) { console.log('Error: ' + err.message); })
    .pipe(source('app.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init({loadMaps: true}))
    // .pipe(uglify())
    .pipe(rename({
      basename: 'app',
      suffix: '.min'
    }))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(dist.redux));
});

// Copies font and image files
gulp.task('copy', function() {
  gulp.src(staticRes, { base: './resources/assets'})
    .pipe(gulp.dest('./public'));
});

// Browsersync
gulp.task('browser-sync', function() {
  browserSync.init({
    proxy: process.env.APP_URL
  });
});

/**
 * Default task
 */
gulp.task('default', ['sass', 'admin-sass', 'js', 'vendor', 'copy'], function() {
  watch([res.scss + '/**/*.scss'], { usePolling: true }, function() { gulp.start(['sass', 'admin-sass']); });
  watch([res.js + 'main.js'], { usePolling: true }, function() { gulp.start(['js']); });
  watch([res.vendor + '**/*.js'], { usePolling: true }, function() { gulp.start(['vendor']); });
  watch(staticRes, { usePolling: true }, function() { gulp.start(['copy']); });
});

/**
 * Default tasks to be run on your local machine if you want to use BrowserSync
 */
gulp.task('local', ['sass', 'admin-sass', 'js', 'vendor', 'copy', 'browser-sync'], function() {
  watch([res.scss + '/**/*.scss'], function() { gulp.start(['sass', 'admin-sass']); });
  watch([res.js + 'main.js'], function() { gulp.start(['js']); });
  watch([res.vendor + '**/*.js'], function() { gulp.start(['vendor']); });
  watch(staticRes, function() { gulp.start(['copy']); });
  watch([res.assets], function() { gulp.start(reload); });
});
