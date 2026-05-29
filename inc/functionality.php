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

/* Shortcode: Polylang manuell översättning (Användning: [pll_string name="unik_nyckel" default="Ursprungstext"])
================================================== */

// Registrera sparade strängar på init så Polylang hinner plocka upp dem
function seod_register_pll_strings() {
  if ( ! function_exists( 'pll_register_string' ) ) return;
  $strings = get_option( 'seod_pll_strings', [] );
  foreach ( $strings as $name => $default ) {
    pll_register_string( $name, $default, 'Shortcode strängar' );
  }
}
add_action( 'init', 'seod_register_pll_strings' );

function seod_shortcode_pll_string( $atts ) {
  $atts = shortcode_atts( [
    'name'    => '',
    'default' => '',
  ], $atts, 'pll_string' );

  if ( empty( $atts['name'] ) ) return '';

  // Spara strängen i option så den registreras på init vid nästa laddning
  $strings = get_option( 'seod_pll_strings', [] );
  if ( ! array_key_exists( $atts['name'], $strings ) || $strings[ $atts['name'] ] !== $atts['default'] ) {
    $strings[ $atts['name'] ] = $atts['default'];
    update_option( 'seod_pll_strings', $strings );
  }

  if ( function_exists( 'pll__' ) ) {
    return esc_html( pll__( $atts['default'] ) );
  }

  return esc_html( $atts['default'] );
}
add_shortcode( 'pll_string', 'seod_shortcode_pll_string' );

/* Menu toogle element
================================================== */
function add_expand_collapsable_placeholder( $items, $args ) {
  $items = preg_replace( '/<\/li>/', '<span class="menu-toggle"></span></li>',  $items );

  return $items;
}
add_filter('wp_nav_menu_items','add_expand_collapsable_placeholder', 10, 2);
