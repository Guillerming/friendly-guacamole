const { src } = require('gulp');
const config = require('../config');
const gulpCopy = require('gulp-copy');

function copy_src() {
    return src(['src/**/*'])
        .pipe(gulpCopy(config.cfg.path.dist, {prefix: 1}));
}

exports.run = copy_src;