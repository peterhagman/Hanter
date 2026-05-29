<?php
/* Enqueue files
================================================== */
function seod_enqueue_files() {
	$temp_dir = get_stylesheet_directory_uri();
	wp_enqueue_style( 'style',  $temp_dir . '/css/style.min.css', array(), false, 'all' );
	wp_enqueue_script( 'slick', $temp_dir . '/js/slick.min.js', array('jquery' ), false, true);
  	wp_enqueue_script( 'main', $temp_dir . '/js/main.min.js', array('jquery' ), false, true);
}
add_action( 'wp_enqueue_scripts', 'seod_enqueue_files' );
