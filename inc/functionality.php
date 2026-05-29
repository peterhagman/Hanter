<?php
/* Registrera navigationsmenyer
================================================== */
register_nav_menus( [
  'losningar' => __( 'Lösningar', 'hanter' ),
  'support'   => __( 'Support', 'hanter' ),
  'om-oss'    => __( 'Om oss', 'hanter' ),
] );

/* Shortcode: Rendera WP-meny baserat på menyns namn (Användning: [wp_menu name="Menynamn"] eller [wp_menu name="Menynamn" depth="2"])
================================================== */
function seod_shortcode_wp_menu( $atts ) {
  $atts = shortcode_atts( [
    'name'  => '',
    'depth' => 0,
    'class' => '',
  ], $atts, 'wp_menu' );

  if ( empty( $atts['name'] ) ) {
    return '';
  }

  return wp_nav_menu( [
    'theme_location'  => $atts['name'],
    'depth'           => (int) $atts['depth'],
    'menu_class'      => $atts['class'] ?: 'menu',
    'container'       => false,
    'echo'            => false,
    'fallback_cb'     => false,
  ] );
}
add_shortcode( 'wp_menu', 'seod_shortcode_wp_menu' );

/* Menu toogle element
================================================== */
function add_expand_collapsable_placeholder( $items, $args ) {
  $items = preg_replace( '/<\/li>/', '<span class="menu-toggle"></span></li>',  $items );

  return $items;
}
add_filter('wp_nav_menu_items','add_expand_collapsable_placeholder', 10, 2);
