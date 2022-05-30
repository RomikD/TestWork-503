<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div class="container">
        <div class="main-title">
            <h1><?php the_title(); ?></h1>
        </div>
        <?php the_content(); ?>
    </div>
<?php endwhile; wp_reset_query(); ?>

<?php get_footer(); ?>