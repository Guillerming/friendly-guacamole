const watchdo = require('../tasks/watchdo');
const gulpWatch = require('gulp-watch');

const filesToWatch = [
    'src/**/*'
];


function watch() {
    // First time execution
    watchdo.run();
    // Watch execution
    return gulpWatch(filesToWatch, () => {
        console.log('');
        watchdo.run();
    });
}

exports.run = watch;