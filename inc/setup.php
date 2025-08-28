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

/* Admin remove Divi project
================================================== */
function seod_remove_project_posttype( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	));
}
add_filter( 'et_project_posttype_args', 'seod_remove_project_posttype', 10, 1 );

/* Admin logotype style
================================================== */
function seod_admin_login() { ?>
 <style type="text/css">
   body.login {
     background-color: #e2e2e2;
   }
   #login h1 a, .login h1 a {
     background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/img/logotype.png') !important;
     background-position: center !important;
     -webkit-background-size: contain !important;
     -moz-background-size: contain !important;
     -o-background-size: contain !important;
     background-size: contain !important;
     width: 250px !important;
     height: 140px !important;
   }
 </style>
<?php }
add_action( 'login_enqueue_scripts', 'seod_admin_login' );

/* Admin logotype URL
================================================== */
function seod_admin_logotype_url() {
  return home_url();
}
add_filter( 'login_headerurl', 'seod_admin_logotype_url' );

/* Admin menu
================================================== */
function seod_admin_menu(){
  remove_menu_page( 'edit.php' );
  remove_menu_page( 'edit-comments.php' );
  remove_menu_page( 'yikes-woo-settings' );
}
add_action( 'admin_menu', 'seod_admin_menu' );

/* Admin bar
================================================== */
function seod_admin_bar() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
  $wp_admin_bar->remove_menu('comments');
  $wp_admin_bar->remove_menu('new-content');
}
add_action('wp_before_admin_bar_render', 'seod_admin_bar', 0);

/* Admin footer text
================================================== */
function seod_admin_footer() {
  echo 'Webbplats producerad av <a href="https://seodesign.se/" target="_blank" rel="noopener noreferrer">SEO DESIGN</a>';
}
add_filter('admin_footer_text', 'seod_admin_footer');

/* Remove protected text
================================================== */
function seod_remove_protected_text() {
  return __('%s');
}
add_filter( 'protected_title_format', 'seod_remove_protected_text' );

/* Remove version param from js and cs
================================================== */
function seod_remove_version( $src ) {
  if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
    $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'seod_remove_version', 9999 );
add_filter( 'script_loader_src', 'seod_remove_version', 9999 );

/* Fix unstyled page load
================================================== */
add_action('wp_head', 'seod_divi_page_load');
function seod_divi_page_load(){ ?>
<script type="text/javascript">
  var elm=document.getElementsByTagName("html")[0];
  elm.style.display="none";
  document.addEventListener("DOMContentLoaded",function(event) {elm.style.display="block"; });
</script>
<?php
}


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
          return current_user_can( 'list_users' ); // Only admins
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