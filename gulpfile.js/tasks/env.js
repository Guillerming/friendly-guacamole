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

function settingsJson() {
    var settings = {
        version: getVersion(),
        base_url: config.cfg.env[environment].base_url
    };
    return src(config.cfg.path.dist + 'app/settings.json')
        .pipe(pupa(settings))
        .pipe(dest(config.cfg.path.dist + 'app/'));
}

async function environment_dev() {
    environment = 'dev';
    settingsJson();
}


async function environment_staging() {
    environment = 'staging';
    settingsJson();
}


async function environment_prod() {
    environment = 'prod';
    settingsJson();
}


exports.dev = environment_dev;
exports.staging = environment_staging;
exports.prod = environment_prod;