const { src, dest } = require('gulp');
const config = require('../config');

const gulpMinify = require('gulp-uglify');
const gulpConcat = require('gulp-concat');

function minify_js() {
    return src( 'src/assets/js/**/*')
        .pipe(gulpMinify())
        .pipe(gulpConcat('aiffinity.min.js'))
        .pipe( dest( config.cfg.path.dist + 'assets/js/') );
}

exports.run = minify_js;