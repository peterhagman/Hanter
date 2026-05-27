<?php

/* Remove Gutenberg css
================================================== */
add_action( 'wp_enqueue_scripts', function() {
	wp_dequeue_style( 'wp-block-library' );
});

/* Viewport scale
================================================== */
remove_action('wp_head', 'et_add_viewport_meta');
add_action('wp_head', 'seod_enable_pinch_zoom');
function seod_enable_pinch_zoom() {
  echo '<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=0.1, maximum-scale=5.0">';
}

/* Remove version param from js and cs
================================================== */
function seod_remove_version( $src ) {
  if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
    $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'seod_remove_version', 9999 );
add_filter( 'script_loader_src', 'seod_remove_version', 9999 );
