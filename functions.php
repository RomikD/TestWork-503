<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

/**
 *  Load version control code
 */
require_once( __DIR__ . '/core/components/_version-control.php');

/**
 *  Load root files code
 */
require_once( __DIR__ . '/core/components/_root-files-loading.php');

/**
 *  Load scripts and styles files code
 */
require_once( __DIR__ . '/core/components/_theme-files.php');

/**
 *  Load other necessary function for plugins, WordPress, etc.
 */
require_once( __DIR__ . '/core/components/_themes-settings.php');

/**
 *  Load other necessary function for Woocommerce plugin. (If woocommerce used).
 */
require_once( __DIR__ . '/core/components/_wc-functions.php');