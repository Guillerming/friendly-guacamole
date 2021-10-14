const { src } = require('gulp');
const gulpClean = require('gulp-clean');
const config = require('../config');

function delete_dev_files() {
    return src([
            config.cfg.path.dist + 'assets/scss',
            config.cfg.path.dist + 'assets/js/plugins'
        ])
        .pipe(gulpClean({force: true}));
}

exports.run = delete_dev_files;