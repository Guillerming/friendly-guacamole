const { src, dest } = require('gulp');
const config = require('../config');
const projectjson = require('../../src/app/settings.json');

const minify = require('gulp-uglify');
const concat = require('gulp-concat');

function dependencies_js() {
    var scripts = projectjson.dependencies.scripts;
    for ( var n = 0; n < scripts.length; n++ ) {
        scripts[n] = 'node_modules/' + scripts[n];
    }
    return src(scripts)
        .pipe(minify())
        .pipe(concat('dependencies.js'))
        .pipe(dest(config.cfg.path.dist + 'assets/js/'));
}

function minify_js() {
    return src('src/assets/js/**/*')
        .pipe(minify())
        .pipe(concat('scripts.js'))
        .pipe(dest(config.cfg.path.dist + 'assets/js/'));
}

exports.dependencies = dependencies_js;
exports.run = minify_js;