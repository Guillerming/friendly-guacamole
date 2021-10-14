const { src } = require('gulp');
const config = require('../config');
const gulpClean = require('gulp-clean');

function clean() {
    return src(config.cfg.path.dist + '*')
        .pipe(gulpClean({force: true}));
}

exports.run = clean;