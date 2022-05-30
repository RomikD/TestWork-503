<?php get_header(); ?>
    <div class="container">
        <?php if ( have_posts() ) while ( have_posts() ) : the_post();
            //Outputs the content
            the_content();
        endwhile; wp_reset_query(); ?>
    </div>
<?php get_footer(); ?>