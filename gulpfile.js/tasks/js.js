'use strict';
const { src, dest, parallel } = require('gulp');
const config = require('../config');

const minify = require('gulp-uglify');
const concat = require('gulp-concat');

let scriptsMap;

function concat_min_vendor() {
    scriptsMap = require('../../build/app/temp.scripts.json');
    return src(scriptsMap.vendor)
        .pipe(minify())
        .pipe(concat('main.js'))
        .pipe(dest(config.cfg.path.dist + 'public/assets/js/'));
}

function minify_user_scripts() {
    let cwd = __dirname;
    cwd = cwd.split('/');
    for ( let n = 0; n < cwd.length; n++ ) {
        if ( cwd.pop() != 'gulpfile.js' ) {
            continue;
        } else {
            break;
        }
    }
    cwd = cwd.join('/');
    // console.log(cwd);
    // return src('*');
    scriptsMap = require('../../build/app/temp.scripts.json');
    return scriptsMap.user.forEach(( user ) => {
        return user.files.forEach(( filename ) => {
            filename = filename.replace( cwd + '/', '');
            let path = filename.split('/');
            filename = path[path.length - 1];
            path.pop();
            path = path.join('/') + '/';
            return src(path + filename)
                .pipe(minify())
                .pipe(dest(path));
        })
    });
}

exports.run = parallel(concat_min_vendor, minify_user_scripts);