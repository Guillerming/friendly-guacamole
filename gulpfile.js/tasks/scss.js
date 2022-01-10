'use strict';
const { src, dest } = require('gulp');
const config = require('../config');

const rename = require('gulp-rename');
const sass = require('gulp-dart-sass');

function compile() {
    return src(config.cfg.path.dist + 'app/temp.styles.scss')
        .pipe(sass())
        .pipe(rename('styles.css'))
        .pipe(dest(config.cfg.path.dist + 'public/assets/css/'));
}

exports.run = compile;