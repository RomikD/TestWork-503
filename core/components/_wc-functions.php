<?php
/**
 *  There are all necessary functions for Woocommerce Plugin.
 *  Allows to add some functionality for your website.
 *  Do not forget to initial that in functions.php (root directory).
 */

/**
 *   Allows you to make changes in root/core/plugins/woocommerce/
 */
add_theme_support('woocommerce');

/**
 *   Allows you to move main WC template directory under some folders.
 */
add_filter( 'woocommerce_template_path', function( $path ) use ($path_files, $my_path) {
    //Init your route to folder.
    $path_files = '/core/plugins/woocommerce/';
    //Create full route
    $my_path = get_stylesheet_directory() . $path_files;
    //Changes default route.
    return file_exists( $my_path ) ? $path_files : $path;
});

/**
 *   Add support of features for custom theme
 */
add_action( 'after_setup_theme', 'kallisto_woocommerce_setup' );
function kallisto_woocommerce_setup() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

/**
 *   Unable woocommerce styles
 */
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


/**
 *   Remove unused function in woocommerce_single_product_summary
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

/**
 *   Moving text inside span in message block Woocommerce
 */
add_filter( 'wc_add_to_cart_message_html', 'custom_add_to_cart_message_html', 10, 2 );
function custom_add_to_cart_message_html( $message, $products ) {
    $count = 0;
    foreach ( $products as $product_id => $qty ) {
        $count += $qty;
    }
    // The custom message is just below
    $added_text = sprintf( _n("%s יש לפריט %s", "%s יש לפריטים %s", $count, "woocommerce" ),
        $count, __("נוספו לסל שלך.", "woocommerce") );

    // Output success messages
    if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
        $return_to = apply_filters( 'woocommerce_continue_shopping_redirect', wc_get_raw_referer() ? wp_validate_redirect( wc_get_raw_referer(), false ) : wc_get_page_permalink( 'shop' ) );
        $message   = sprintf( '<span>%s</span><a href="%s" class="button wc-forward">%s</a>', esc_html( $added_text ), esc_url( $return_to ), esc_html__( 'Continue shopping', 'woocommerce' ) );
    } else {
        $message   = sprintf( '<span>%s</span><a href="%s" class="button wc-forward">%s</a>', esc_html( $added_text ), esc_url( wc_get_page_permalink( 'cart' ) ), esc_html__( 'View cart', 'woocommerce' ) );
    }
    return $message;
}

/**
 *   Remove unused function in woocommerce_before_main_content
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 *  Register new endpoint (URL) for My Account page
 *  Note: Re-save Permalinks or it will give 404 error
 */
add_action( 'init', 'my_custom_endpoints' );
function my_custom_endpoints() {
    add_rewrite_endpoint( 'add-product', EP_ROOT | EP_PAGES );
}

add_filter( 'query_vars', 'my_custom_query_vars', 0 );
function my_custom_query_vars( $vars ) {
    $vars[] = 'add-product';

    return $vars;
}

add_action( 'wp_loaded', 'product_flush_rewrite_rules' );
function product_flush_rewrite_rules() {
    flush_rewrite_rules();
}

/**
 *  Add content to the new tab
 */
add_action( 'woocommerce_account_add-product_endpoint', 'kallisto_product_content' );
function kallisto_product_content() {
    //Init your route to folder.
    $path_files = '/core/plugins/woocommerce/';
    //Create full route
    $my_path = get_stylesheet_directory() . $path_files;

    include $my_path .'myaccount/form-add-product.php';
}

/**
 *  Add tab to my account page
 */
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );
function custom_my_account_menu_items( $items ) {
    $items = array(
        'add-product'     => 'Add product',
        'edit-account'    => __( 'Edit Account', 'woocommerce' ),
        'customer-logout' => __( 'Logout', 'woocommerce' ),
    );

    return $items;
}

/**
 *  Remove dashboard in my account page
 */
add_filter( 'woocommerce_account_menu_items', 'remove_my_account_dashboard' );
function remove_my_account_dashboard( $menu_links ){
    unset( $menu_links['dashboard'] );
    return $menu_links;

}

/**
 *  Remove orders in my account page
 */
add_filter( 'woocommerce_account_menu_items', 'remove_my_account_orders' );
function remove_my_account_orders( $menu_links ){
    unset( $menu_links['Orders'] );
    return $menu_links;
}

/**
 *  Register new custom field for products
 */
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );
function woo_add_custom_general_fields() {

    echo '<div class="options_group">';

    woocommerce_wp_select( array( // Text Field type
        'id'          => '_product_type_select',
        'label'       => __( 'Product type', 'woocommerce' ),
        'description' => __( 'Select product special type', 'woocommerce' ),
        'desc_tip'    => true,
        'options'     => array(
            ''        => __( 'Select product special type', 'woocommerce' ),
            'productType-0'   => __( 'Rare', 'woocommerce' ),
            'productType-1'   => __( 'Frequent', 'woocommerce' ),
            'productType-2'   => __( 'Unusual', 'woocommerce' )

        )
    ) );

    echo '</div>';
}

// Save Fields values to database when submitted (Backend)
add_action( 'woocommerce_process_product_meta', 'woo_save_custom_general_fields', 30, 1 );
function woo_save_custom_general_fields( $post_id ){
    // Saving "Conditions" field key/value
    $posted_field_value = $_POST['_Stan'];
    if( ! empty( $posted_field_value ) ) {
        update_post_meta($post_id, '_product_type_select', esc_attr($posted_field_value));
    }
}

?>