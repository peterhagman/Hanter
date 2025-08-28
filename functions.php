<?php

/* Parent theme style
================================================== */
function seod_child_enqueue_styles() {
  wp_enqueue_style( 'parent-theme-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'seod_child_enqueue_styles' );

/* Inkl files to child theme
================================================== */
function seod_theme_setup() {
  $dir_inc = __DIR__ . '/inc';
  require_once($dir_inc . '/enqueue.php');
  require_once($dir_inc . '/admin.php');
  require_once($dir_inc . '/security.php');
  require_once($dir_inc . '/performance.php');
}
add_action('after_setup_theme', 'seod_theme_setup');
