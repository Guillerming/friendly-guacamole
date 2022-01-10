'use strict';
const { src, dest } = require('gulp');
const config = require('../config');

const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-dart-sass');

function compile() {
    return src(config.cfg.path.dist + 'app/temp.styles.scss')
        .pipe(sourcemaps.init())
        .pipe(sass(config.cfg.sass))
        .pipe(rename('styles.css'))
        .pipe(sourcemaps.write('/maps'))
        .pipe(dest(config.cfg.path.dist + 'public/assets/css/'));
}

exports.run = compile;