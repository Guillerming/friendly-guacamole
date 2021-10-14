// import gulp and config
const { series, parallel } = require('gulp');
const config = require('./config');

// importing tasks
const clean = require('./tasks/clean');
const copy = require('./tasks/copy');
const scss = require('./tasks/scss');
const js = require('./tasks/js');
const env = require('./tasks/env');
const delete_dev_files = require('./tasks/delete-dev-files');

const watch = require('./tasks/watch');

// exporting tasks

exports.watch = watch.run;
exports.staging = series(
    clean.run,
    parallel(
        scss.run,
        js.run,
        copy.run,
    ),
    parallel(
        env.staging,
        delete_dev_files.run
    )
);
exports.prod = series(
    clean.run,
    parallel(
        js.run,
        scss.run,
        copy.run,
    ),
    parallel(
        delete_dev_files.run,
        env.prod
    )
);