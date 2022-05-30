/**
 *  This is copy function to create compiled files dynamic in real time to ./source/dist
 */

export const copy = () => {

    //Get the files pre-code
    return app.gulp.src(
        app.path.src.files
    )
        .pipe(
            app.gulp.dest(
                app.path.build.files
            )
        )
}