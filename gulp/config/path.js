/**
 *  This is path configuration file where we get code, files, etc for using it in gulp to compile
 *  Use only path *
 */

// Get name of root folder
import * as nodePath from 'path';
const rootFolder = nodePath.basename(nodePath.resolve());


// The result folder where we get final code to use
const buildFolder = `./source/dist`;

// The pre-code folder where we get pre-result code to use
const srcFolder = `./source/src`;

// General object where will contain all path to files in project
export const path = {
    build: {
        js: `${buildFolder}/`,
        css: `${buildFolder}/`,
        files: `${buildFolder}/`
    },
    src: {
        js: `${srcFolder}/js/app.js`,
        scss: `${srcFolder}/css/main.scss`,
        files: `${srcFolder}/**/*.*`,
    },
    watch: {
        js: `${srcFolder}/js/**/*.js`,
        scss: `${srcFolder}/css/**/*.scss`,
        files: `${srcFolder}/**/*.*`,
    },
    clean: buildFolder,
    buildFolder: buildFolder,
    srcFolder: srcFolder,
    rootFolder: rootFolder
}