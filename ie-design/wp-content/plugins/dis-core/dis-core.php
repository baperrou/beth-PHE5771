<?php
/*
Plugin Name: DOITSIMPLY DESIGN Core
Plugin URI: http://www.doitsimply.co.uk
Description: do it simply design core functionality (required for themes)
Author: Do It Simply
Version: 1.0
Author URI: http://www.doitsimply.co.uk
*/

//MAINTENANCE MODE
if ($_SERVER['REMOTE_ADDR'] != "" && !is_admin() && false):
    include("maintenance.html");
    exit;
endif;

//SUPERADMIN MODE
if ($_SERVER['REMOTE_ADDR'] == ""):
    define('IS_SUPERADMIN_MODE', true); //SET AS TRUE TO RESTORE MENUS AND PERMISSIONS FOR THIS IP ^^
   // define('ACF_LITE', true);
else:
    define('IS_SUPERADMIN_MODE', true);
   // define('ACF_LITE', true);
endif;

//COMMON IOP
include('outputs.php');
include('form_outputs.php');
include('processes.php');

//COMMON METHODS
include('includes/classes.php');
include('includes/actions.php');
include('includes/filters.php');


add_action('init', 'custom_init', 10);
add_action('admin_menu', 'custom_admin_menu', 999);

//JAVSCRIPT ACTIONS

add_action('wp_ajax_nopriv_get_ajax_functions', 'get_ajax_functions');
add_action('wp_ajax_get_ajax_functions', 'get_ajax_functions');


add_action('wp_ajax_beth_insert_term', 'beth_insert_term');
add_action('wp_ajax_nopriv_beth_insert_term', 'beth_insert_term');
wp_localize_script('beth_insert_term', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));  
 
add_action('wp_ajax_create_user_cpt', 'create_user_cpt');
add_action('wp_ajax_nopriv_create_user_cpt', 'create_user_cpt');
wp_localize_script('create_user_cpt', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));   

add_action('wp_ajax_check_user_cpt', 'check_user_cpt');
add_action('wp_ajax_nopriv_check_user_cpt', 'check_user_cpt');
wp_localize_script('check_user_cpt', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));   


wp_register_script('ajax_functions', get_template_directory_uri() . '/js/pages/ajax_functions.js', array('jquery'), '', true );


wp_localize_script('ajax_functions', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php'))); 
wp_enqueue_script('ajax_functions');       
wp_enqueue_script('jquery');




add_filter( 'body_class', 'add_body_class' );


