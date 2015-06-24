var gulp    = require('gulp');
var watch   = require('gulp-watch');
var sass    = require('gulp-ruby-sass');
var uglify  = require('gulp-uglifyjs');

var cssDir  = 'scss';
var jsDir   = 'js';

var jsListUser = 
[
	jsDir+'/dd-user.js'
];

gulp.task('watch', function () 
{
	gulp.watch(cssDir + '/**/*.scss', ['css']);
	gulp.watch(jsDir + '/**/*.js', ['js']);
}); 

gulp.task('css', function () 
{
  return sass(cssDir)
  .pipe(gulp.dest('./assets/css'));   
});

gulp.task('js', function () 
{
  	gulp.src(jsListUser)
    .pipe(uglify('dd-user.js'))
    .pipe(gulp.dest('./assets/js'));
});


gulp.task('default', ['css', 'js']); 