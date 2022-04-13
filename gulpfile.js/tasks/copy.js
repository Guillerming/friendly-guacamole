const { src, series } = require('gulp');
const config = require('../config');
const gulpCopy = require('gulp-copy');

function copy_src() {
    return src(['src/**/*', 'src/public/.htaccess'])
        .pipe(gulpCopy(config.cfg.path.dist, {prefix: 1}));
}

function copy_images() {
    return src(['src/app/assets/images/**/*'])
        .pipe(gulpCopy(config.cfg.path.dist + 'public/assets/images/', {prefix: 4}));
}

exports.run = series( copy_src, copy_images );