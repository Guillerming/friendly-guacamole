'use strict';
const { src, dest } = require('gulp');
const config = require('../config');

const minify = require('gulp-uglify');
const concat = require('gulp-concat');

let scriptsMap;

function minify_js() {
    scriptsMap = require('../../build/app/temp.scripts.json');
    return src(scriptsMap.vendor)
        .pipe(minify())
        .pipe(concat('main.js'))
        .pipe(dest(config.cfg.path.dist + 'public/assets/js/'));
}

exports.run = minify_js;