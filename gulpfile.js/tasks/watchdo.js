const { series, parallel } = require('gulp');

const clean = require('../tasks/clean');
const env = require('../tasks/env');
const copy = require('../tasks/copy');
const scss = require('../tasks/scss');
const js = require('../tasks/js');

const runner = require("child_process");

function extract_styles(cb) {
    const phpScriptPath = 'src/_core/scripts/extract.styles.php';
    const argsString = '';
    runner.exec("php " + phpScriptPath + " " + argsString, function(err, phpResponse, stderr) {
        if(err) console.log(err); /* log error */
        console.log( phpResponse );
        cb();
    });
}

function extract_scripts(cb) {
    const phpScriptPath = 'src/_core/scripts/extract.scripts.php';
    const argsString = '';
    runner.exec("php " + phpScriptPath + " " + argsString, function(err, phpResponse, stderr) {
        if(err) console.log(err); /* log error */
        console.log( phpResponse );
        cb();
    });
}

exports.run = series(
    clean.run,
    parallel(
        copy.run,
    ),
    parallel(
        extract_styles,
        extract_scripts,
    ),
    parallel(
        env.dev,
        scss.run,
        js.run,
    )
);