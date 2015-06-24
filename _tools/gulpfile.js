var gulp = require('gulp'),
	bower = require('bower-main'),
	gutil = require('gulp-util'),
	gulpif = require('gulp-if'),
	notify = require('gulp-notify'),	
	sass = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify');

var isDev  = true;
var isProd = false;

var basePath = {
  src  : '../_uncompressed/',
  dest : '../'
};

// If "production" is passed from the command line then update the defaults
if(gutil.env._[0] === 'production') {
  isDev  = false;
  isProd = true;
}

var srcAssets = {
  styles  : basePath.src + 'scss/',
  scripts : basePath.src + 'js/',
  images  : basePath.src + 'images/',
  bower   : '../_tools/bower_components/'
};

var destAssets = {
  styles  : basePath.dest + 'css/',
  scripts : basePath.dest + 'js/',
  images  : basePath.dest + 'images/'
};

var bowerMainJavaScriptFiles = bower('js','min.js');

gulp.task('sass', function() { 
	return gulp.src(srcAssets.styles+'*.scss')
		.pipe(sass({
			includePaths: [
				srcAssets.bower + 'foundation/scss/'
			],
			outputStyle: 'compressed', //isProd ? 'compressed' : 'nested',
			errLogToConsole: true
		}))
		.on('error', notify.onError(function(error) { 
			'SASS Error <%= error.message %>'
		}))
		.pipe(autoprefixer())
		.pipe(gulp.dest(destAssets.styles))
		.pipe(notify('SASS Compiled'));
});

gulp.task('js', function() { 
	return gulp.src([srcAssets.bower+'parsleyjs/dist/parsley.js', srcAssets.scripts+'rsvp.virginhotels.js'])
		.pipe(concat('rsvp.virginhotels.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest(destAssets.scripts));	
});

gulp.task('watch', function() { 
	gulp.watch(srcAssets.styles+'**/*.scss', ['sass']);
	gulp.watch(srcAssets.scripts+'*.js', ['js']);
});

gulp.task('bower_files', function() { 
	 	
	return gulp.src(bowerMainJavaScriptFiles.minified)
		.pipe(gulp.dest(destAssets.scripts));
	
});

gulp.task('prep', ['bower_files']);

gulp.task('default', ['watch']);