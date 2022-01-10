const { series, parallel } = require('gulp');

const clean = require('../tasks/clean');
const copy = require('../tasks/copy');
const scss = require('../tasks/scss');

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

exports.run = series(
    clean.run,
    parallel(
        copy.run,
    ),
    extract_styles,
    scss.run
);