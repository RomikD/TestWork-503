<?php
/*
*  Template Name: Homepage
*/
?>

<?php get_header(); ?>

<?php $args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1, //No limit
    'orderby'        => 'date',
    'hide_empty'     => false,
);
$products_more = new WP_Query( $args );
if ( $products_more->have_posts() ) { ?>
    <section id="products">
        <div class="container">
            <div class="main-title">
                <h2>Our product</h2>
            </div>
            <?php $index = 0; while ( $products_more->have_posts() ) : $products_more->the_post();
                $product = wc_get_product( $products_more->post->ID );
                $product_title = get_the_title();
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $products_more->post->ID ), 'single-post-thumbnail' );
                $regular_price = (int) $product->get_price();
            ?>
                <div class="item">
                    <div class="container">
                        <div class="thumbnail">
                            <img src="<?php echo $image[0] ?>" alt="product-item-<?php echo $index; $index++; ?>">
                        </div>
                        <div class="content">
                            <div class="title">
                                <h4><?php echo $product_title; ?></h4>
                            </div>
                            <div class="price">
                                <p><?php echo $regular_price; ?>$</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
<?php } wp_reset_postdata(); ?>
<?php get_footer(); ?>