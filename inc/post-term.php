<?php 

/* Init Custom Post Term
================================================== */
function seod_post_term() {
  $dir = dirname(__FILE__);
  foreach (glob($dir . '/post-term/*.php') as $phpfile) {
    require_once($phpfile);
  }
}
add_action('init', 'seod_post_term');
