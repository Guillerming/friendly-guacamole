'use strict';
const { src, dest } = require('gulp');
const config = require('../config');
const projectjson = require('../../src/app/settings.json');

const concat = require('gulp-concat');
const sass = require('gulp-dart-sass');

function process_dependencies() {
    var styles = projectjson.dependencies.styles;
    for ( var n = 0; n < styles.length; n++ ) {
        styles[n] = 'node_modules/' + styles[n];
    }
    return src(styles)
        .pipe(sass())
        .pipe(concat('dependencies.css'))
        .pipe(dest(config.cfg.path.dist + 'assets/css/'));
}

function process_scss() {
    return src('src/assets/scss/main.scss')
        .pipe(sass())
        .pipe(dest(config.cfg.path.dist + 'assets/css/'));
}

exports.dependencies = process_dependencies;
exports.run = process_scss;