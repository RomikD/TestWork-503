/**
 *  This is path scenery configuration file where we get code, files, etc for using it in gulp to compile.
 */

// Get main module
import gulp from "gulp";

// Import path.js
import { path } from "./gulp/config/path.js";

// Import main plugins from plugins.js
import { plugins } from "./gulp/config/plugins.js";

// Passing a value to a global variable
global.app = {
    isBuild: process.argv.includes('--build'),
    isDev: !process.argv.includes('--build'),
    path: path,
    gulp: gulp,
    plugins: plugins
}

// Import tasks from ./gulp/tasks/...
import { copy } from "./gulp/tasks/copy.js";
import { reset } from "./gulp/tasks/reset.js";
import { scss } from "./gulp/tasks/scss.js";
import { js } from "./gulp/tasks/app.js";

// File change watcher in ./source/src/...

function wathcer() {
    gulp.watch(
        path.watch.files
    );
    gulp.watch(
        path.watch.scss, scss
    );
    gulp.watch(
        path.watch.js, js
    );
}

// Main tasks to do
const mainTasks = gulp.parallel(scss, js)

// Executing the Default Script
const dev = gulp.series(reset, mainTasks, gulp.parallel(wathcer));
const build = gulp.series(reset, mainTasks);

// Exports taskes to do
export { dev }
export { build }

gulp.task('default', dev);