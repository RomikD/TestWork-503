<?php

function upload_image($file, $post_id){
    if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $attachment_id = media_handle_upload($file, $post_id);

    return $attachment_id;
}

function create_Products_Programmatically($name, $content, $number, $createDate, $stock, $regPrice, $salePrice, $productFtr, $sku, $productType, $image){
    // Set number of products to create
    $product_name = $name;
    $product_content = $content;
    $number_of_products = $number;
    $stock_status = $stock;
    $regular_price = $regPrice;
    $sale_price = $salePrice;
    $featured = $productFtr;
    $sku_number = $sku;
    $date = $createDate;
    $product_type = $productType;
    $productImage = $image;

    $post_id = wp_insert_post( array(
            'post_title'   => $product_name,
            'post_type'    => 'product',
            'post_date'    => $date,
            'post_content' => $product_content,
            'post_status'  => 'publish'
        )
    );

    // Get the upload attachment files
    if ( $_FILES ) {
        $files = $_FILES['productImage'];
        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array(
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                );

                $_FILES = array("agp_gallery" => $file);

                foreach ($_FILES as $file => $array)
                {
                    $newupload = upload_image($file, $post_id);
                }
            }

        }
    }

    // Then we use the product ID to set all the posts meta
    wp_set_object_terms( $post_id, 'simple', 'product_type' ); // set product is simple/variable/grouped
    update_post_meta( $post_id, '_visibility', 'visible' );
    update_post_meta( $post_id, '_stock_status', $stock_status);
    update_post_meta( $post_id, 'total_sales', '0' );
    update_post_meta( $post_id, '_downloadable', 'no' );
    update_post_meta( $post_id, '_virtual', 'yes' );
    update_post_meta( $post_id, '_regular_price', $regular_price);
    if($sale_price) {
        update_post_meta( $post_id, '_sale_price', $sale_price);
    }
    //Custom post type method
    if($product_type) {
        update_post_meta( $post_id, '_product_type_select', $product_type);
    }
    update_post_meta( $post_id, '_purchase_note', '' );
    update_post_meta( $post_id, '_featured', "yes");
    update_post_meta( $post_id, '_weight', '' );
    update_post_meta( $post_id, '_length', '' );
    update_post_meta( $post_id, '_width', '' );
    update_post_meta( $post_id, '_height', '' );
    update_post_meta( $post_id, '_sku', $sku_number);
    update_post_meta( $post_id, '_product_attributes', array() );
    update_post_meta( $post_id, '_sale_price_dates_from', '' );
    update_post_meta( $post_id, '_sale_price_dates_to', '' );
    update_post_meta( $post_id, '_price', $regular_price);
    update_post_meta( $post_id, '_sold_individually', '' );
    set_post_thumbnail( $post_id, $newupload );
    update_post_meta($post_id, '_product_image_gallery', $newupload);
    update_post_meta( $post_id, '_manage_stock', 'yes' ); // activate stock management
    wc_update_product_stock($post_id, $number_of_products, 'set'); // set 1000 in stock
    update_post_meta( $post_id, '_backorders', 'no' );
}

if($_POST['productStatus'] === "option-1") {
    $stock_get = 'instock';
}else {
    $stock_get = 'outofstock';
}

if($_POST['productFtr'] == 'option-1') {
    $productFeatured = 'yes';
}else {
    $productFeatured = 'no';
}

if( isset( $_POST['productType'] ) ) {
    if ($_POST['productType'] === "productType-0") {
        $sanitize_data = 'productType-0';
    }else if ($_POST['productType'] === "productType-1") {
        $sanitize_data = 'productType-1';
    }else if ($_POST['productType'] === "productType-2") {
        $sanitize_data = 'productType-2';
    }else {
        $sanitize_data = '';
    }
}else {
    $sanitize_data = '';
}

create_Products_Programmatically(
    $_POST['productTitle'],
    $_POST['productAbout'],
    $_POST['productCount'],
    $_POST['productDate'],
    $_POST['productStatus'],
    $_POST['productPrice'],
    '',
    $productFeatured,
    $_POST['productSku'],
    $sanitize_data,
    $_POST['productImage']
);

?>

<div id="add-product">
    <form class="add-product-form" action="#" method="post" enctype="multipart/form-data">
        <div class="title">
            <h3 access="false" id="control-8561473">Adding new product form</h3>
        </div>
        <div class="form-text form-group field-productTitle">
            <label for="productTitle" class="form-text-label">Product name/Title<span class="form-required">*</span></label>
            <input type="text" class="form-productTitle" name="productTitle" access="false" id="productTitle" required="required" aria-required="true">
        </div>
        <div class="form-number form-group field-productPrice">
            <label for="productTitle" class="form-number-label">Product price<span class="form-required">*</span></label>
            <input type="number" class="form-productPrice" name="productPrice" access="false" id="productPrice" required="required" aria-required="true">
        </div>
        <div class="form-number form-group field-productSku">
            <label for="productSku" class="form-number-label">SKU<span class="form-required">*</span></label>
            <input type="number" class="form-productSku" name="productSku" access="false" id="productSku" required="required" aria-required="true">
        </div>
        <div class="form-number form-group field-productCount">
            <label for="productCount" class="form-number-label">Product count<span class="form-required">*</span></label>
            <input type="number" class="form-productCount" name="productCount" access="false" id="productCount" required="required" aria-required="true">
        </div>
        <div class="form-textarea form-group field-productAbout">
            <label for="productAbout" class="form-textarea-label">About product</label>
            <textarea type="textarea" class="form-productAbout" name="productAbout" access="false" id="productAbout"></textarea>
        </div>
        <div class="form-file form-group field-productImage">
            <label for="productImage" class="form-file-label">Product image</label>
            <input type="file" class="form-productImage" name="productImage[]" access="false" accept="image/*" id="productImage">
            <button type="button" class="form-productImageRemove btn-default btn" name="productImageRemove" access="false" style="default" id="productImageRemove">Remove image</button>
        </div>
        <div class="form-date form-group field-productDate">
            <label for="productDate" class="form-date-label">Publish date<span class="form-required">*</span></label>
            <input type="date" class="form-productDate" name="productDate" access="false" id="productDate" required="required" aria-required="true">
        </div>
        <div class="form-select form-group field-productType">
            <label for="productType" class="form-checkbox-group-label">Product Type</label>
            <select class="form-productType" name="productType" id="productType">
                <option value="" selected="true">Select product special type</option>
                <option value="productType-0" id="productType-0">Rare</option>
                <option value="productType-1" id="productType-1">Frequent</option>
                <option value="productType-2" id="productType-2">Unusual</option>
            </select>
        </div>
        <div class="form-select form-group field-productStatus">
            <label for="productStatus" class="form-select-label">Stock status<span class="form-required">*</span></label>
            <select class="form-productSatus" name="productStatus" id="productStatus" required="required" aria-required="true">
                <option value="option-1" selected="true" id="productStatus-0">In stock</option>
                <option value="option-2" id="productStatus-1">out of stock</option>
            </select>
        </div>
        <div class="form-button form-group field-productPublish">
            <button type="submit" class="form-productPublish btn-default btn" name="productPublish" access="false" style="default" id="productPublish">Publish product</button>
            <button type="reset" class="form-productReset btn-default btn" name="productReset" access="false" style="default" id="productReset">Reset form values</button>
        </div>
    </form>
</div>