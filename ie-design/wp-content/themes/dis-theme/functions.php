<?php //DESKTOP TEMPLATE FUNCTIONS
//starting sessions for website


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(!is_plugin_active('dis-core/dis-core.php') && !is_admin()) die("Please activate the DIS Core plugin!");

add_theme_support( 'post-thumbnails' );


global $_desktop;
$_desktop = true;


add_action('wp_footer', 'wp_print_scripts', 40);
add_action('wp_footer', 'wp_enqueue_scripts', 40);
add_action('wp_footer', 'wp_print_head_scripts', 30);



add_filter('excerpt_length', 'custom_desktop_excerpt_length');
add_filter('excerpt_more', 'custom_desktop_excerpt_more' );
add_filter('get_the_excerpt', 'custom_desktop_get_the_excerpt' );
add_filter('wp_nav_menu', 'custom_desktop_wp_nav_menu' );



		
