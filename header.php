<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="date=no">
    <meta name="format-detection" content="address=no">
    <meta name="format-detection" content="email=no">
    <title>
        <?php
          if( ! is_home() ):
            wp_title( '|', true, 'right' );
          endif;
          bloginfo( 'name' );
        ?>
    </title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="navigation">
                <nav class="site-navigation main-navigation">
                    <?php wp_nav_menu(array('theme_location' => 'Primary Header')); ?>
                </nav><!-- #site-navigation -->
            </div>
            <a href="<?php echo get_home_url(); ?>" class="brand-logo">
                <h1>Brand logo</h1>
            </a>
            <div class="menu-btn mob">
                <div class="btn">
                    <span></span>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->
    <div id="fixed-menu" class="mob">
        <div class="container">
            <div class="main">
                <div class="navigation">
                    <nav class="site-navigation main-navigation">
                        <?php wp_nav_menu(array('theme_location' => 'Primary Header')); ?>
                    </nav><!-- #site-navigation -->
                </div>
            </div>
        </div>
    </div>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">