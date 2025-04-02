const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));

const paths = {
    scss: './assets/scss/**/*.scss',
    css: './assets/styles/'
};

function compileSass() {
    return gulp.src(['./assets/scss/**/*.scss', '!./assets/scss/**/_*.scss'])
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(paths.css));
}

function compileBlocksSass() {
    return gulp.src(['./blocks/**/*.scss', '!./blocks/**/_*.scss'], { base: './blocks/' })
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./blocks/'));
}

function watchFiles() {
    gulp.watch(paths.scss, compileSass);
    gulp.watch('./blocks/**/*.scss', compileBlocksSass);
}

exports.sass = compileSass;
exports['sass:blocks'] = compileBlocksSass;
exports.watch = watchFiles;