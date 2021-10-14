'use strict';
const { src, dest } = require('gulp');
const config = require('../config');

const gulpSass = require('gulp-sass');
gulpSass.compiler = require('node-sass');

function process_scss() {
    return src('src/assets/scss/main.scss')
        .pipe(gulpSass.sync(config.cfg.sass).on('error', gulpSass.logError))
        .pipe(dest(config.cfg.path.dist + 'assets/css/'));
}

exports.run = process_scss;