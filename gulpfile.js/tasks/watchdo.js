const { series, parallel } = require('gulp');

const clean = require('../tasks/clean');
const copy = require('../tasks/copy');

exports.run = series(
    clean.run,
    parallel(
        copy.run,
    ),
);