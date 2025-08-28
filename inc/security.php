<?php

/* Remove WP version from header and RSS
================================================== */
remove_action( 'wp_head', 'wp_generator' );

/* Disable file editing in WordPress admin
================================================== */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
  define( 'DISALLOW_FILE_EDIT', true );
}

/* Restrict REST API user endpoint to admins only
================================================== */
add_filter( 'rest_endpoints', function( $endpoints ) {
  if ( isset( $endpoints['/wp/v2/users'] ) ) {
      $endpoints['/wp/v2/users'][0]['permission_callback'] = function() {
          return current_user_can( 'list_users' );
      };
  }
  return $endpoints;
});

/* Enforce strong passwords for all users except admins
================================================== */
add_action( 'user_profile_update_errors', function( $errors, $update, $user ) {
  if ( isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
      if ( strlen( $_POST['pass1'] ) < 12 ) {
          $errors->add( 'weak_password', '<strong>ERROR</strong>: Please use a password with at least 12 characters.' );
      }
  }
}, 10, 3 );