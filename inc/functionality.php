<?php
/* Menu toogle element
================================================== */
function add_expand_collapsable_placeholder( $items, $args ) {
  $items = preg_replace( '/<\/li>/', '<span class="menu-toggle"></span></li>',  $items );

  return $items;
}
add_filter('wp_nav_menu_items','add_expand_collapsable_placeholder', 10, 2);