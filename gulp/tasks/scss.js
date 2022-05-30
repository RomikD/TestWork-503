/**
 *  This is scss function to compile scss files in real time from ./source/dist/css... for new css files
 */

// Import gulp files for work with scss
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
import rename from 'gulp-rename';

import cleanCss from 'gulp-clean-css'; // css file compression
import autoprefixer from 'gulp-autoprefixer'; // Adding vendor prefixes
import groupCssMediaQueries from 'gulp-group-css-media-queries'; // Grouping media queries

const sass = gulpSass(dartSass)

export const scss = () => {
    return app.gulp.src(
        app.path.src.scss, {
            sourcemaps: app.isDev
        }
    )
        .pipe(
            app.plugins.plumber(
                app.plugins.notify.onError({
                    title: "SCSS",
                    message: "Error: <%= error.message %>"
                })
            )
        )
        .pipe(
            sass({
               outputStyle: 'expanded'
            })
        )
        .pipe(
            app.plugins.if(
                app.isBuild,
                groupCssMediaQueries()
            )
        )
        .pipe(
            app.plugins.if(
                app.isBuild,
                autoprefixer({
                    grid: true,
                    overrideBrowserslist: ["last 3 versions"],
                    cascade: true
                })
            )
        )
        .pipe(
            app.plugins.if(
                app.isBuild,
                cleanCss()
            )
        )
        .pipe(
            rename({
                extname: ".min.css"
            })
        )
        .pipe(
            app.gulp.dest(
                app.path.build.css
            )
        )
}