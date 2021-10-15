'use strict';
const { src, dest } = require('gulp');
const config = require('../config');
const projectjson = require('../../src/app/project.json');

const concat = require('gulp-concat');
const sass = require('gulp-sass');
sass.compiler = require('node-sass');

function process_dependencies() {
    var styles = projectjson.dependencies.styles;
    for ( var n = 0; n < styles.length; n++ ) {
        styles[n] = 'node_modules/' + styles[n];
    }
    return src(styles)
        .pipe(sass.sync(config.cfg.sass).on('error', sass.logError))
        .pipe(concat('dependencies.css'))
        .pipe(dest(config.cfg.path.dist + 'assets/css/'));
}

function process_scss() {
    return src('src/assets/scss/main.scss')
        .pipe(sass.sync(config.cfg.sass).on('error', sass.logError))
        .pipe(dest(config.cfg.path.dist + 'assets/css/'));
}

exports.dependencies = process_dependencies;
exports.run = process_scss;