<?php 

/* Init Custom Post Type
================================================== */
function seod_post_type() {
  $dir = dirname(__FILE__);
  foreach (glob($dir . '/post-type/*.php') as $phpfile) {
    require_once($phpfile);
  }
}
add_action('init', 'seod_post_type');
