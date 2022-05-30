<?php
/**
 * Register all necessary files for pages like scripts styles etc.
 * Do not forget to initial that in fucntions.php (root directory)
 */

/**
 * include custom jQuery 3.6.0.
 */
function including_custom_jquery() {
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri().'/source/assets/jquery/jquery.min.js', array(), null, false);
}
add_action('wp_enqueue_scripts', 'including_custom_jquery');

/**
 * Load css styles for font-awesome
 */
function load_font_awesome_styles_plugin() {
    wp_enqueue_style( 'kallisto-font-awesome-style', get_template_directory_uri().'/source/assets/font-awesome/css/font-awesome.min.css');
}
add_action('wp_print_styles', 'load_font_awesome_styles_plugin');

/**
 * Enqueue scripts and styles.
 */
function kallisto_scripts() {
    wp_enqueue_style( 'kallisto-normalize', get_template_directory_uri().'/source/assets/normalize/normalize.min.css');
    wp_enqueue_style( 'kallisto-main-style', get_template_directory_uri().'/source/dist/main.min.css');
    wp_enqueue_style( 'kallisto-style', get_stylesheet_uri(), array(), _Kallisto_VERSION );
    wp_style_add_data( 'kallisto-style', 'rtl', 'replace' );

    wp_enqueue_script( 'kallisto-scripts', get_template_directory_uri() . '/source/dist/app.min.js', array(), _Kallisto_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'kallisto_scripts' );

?>