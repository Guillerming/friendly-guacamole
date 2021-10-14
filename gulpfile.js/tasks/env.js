const config = require('../config');

const { src, dest } = require('gulp');
const package = require('../../package.json');
const timestamp = (new Date()).getTime();
const pupa = require('gulp-pupa');

let environment = null;

function getVersion() {
    var buildVersion = package.version;
    buildVersion = buildVersion.split('.');
    buildVersion[2] = parseInt(timestamp / 1000);
    return buildVersion.join('.');
}

function phpConfig() {
    var obj = {
        version: getVersion(),
        base_url: config.cfg.env[environment].base_url
    };
    return src(config.cfg.path.dist + 'core/config.php')
        .pipe(pupa(obj))
        // .pipe(gulpReplace("'production' => false,", "'production' => " + config.cfg.env[environment].production + ","))
        // .pipe(gulpReplace("'local' => false,", "'local' => " + config.cfg.env[environment].local + ","))
        .pipe(dest(config.cfg.path.dist + 'core/'));
}

async function environment_dev() {
    environment = 'dev';
    phpConfig();
}


async function environment_staging() {
    environment = 'staging';
    phpConfig();
}


async function environment_prod() {
    environment = 'prod';
    phpConfig();
}


exports.dev = environment_dev;
exports.staging = environment_staging;
exports.prod = environment_prod;