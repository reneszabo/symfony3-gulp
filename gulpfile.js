var gulp        = require('gulp');
var connect     = require('gulp-connect-php');
var browserSync = require('browser-sync');
var sass        = require('gulp-sass');

gulp.task('connect-sync', function() {
  connect.server({
    port:8000,
    base:'web'
  }, function (){
    browserSync({
      proxy: 'localhost:8000'
    });
  });
  gulp.watch("scss/**/*.scss", ['sass']);
});

gulp.task('reload', function(){
  browserSync.reload();
});

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function() {
  return gulp.src("scss/**/*.scss")
    .pipe(sass())
    .pipe(gulp.dest("web/css"))
    .pipe(browserSync.stream());
});



gulp.task("default",['connect-sync', 'sass'], function() {
  gulp.watch([
    "./src/**/*.*",
    "./app/**/*.*"
  ],["reload"]);
});
