<?php
//GENERIC
function custom_init()
{
    global $wp_post_types, $wp_rewrite;

    /** Register navigation menus */
    register_nav_menu('main', 'Main Menu');
    register_nav_menu('footer', 'Footer Menu');
    
  
 /** Register 'Summary Score Assessment Level' post type */
    $labels = array(
        'name' => _x('Summary Score', 'post type general name'),
        'singular_name' => _x('Summary Score', 'post type singular name'),
        'add_new' => _x('Add New', 'summary score'),
        'add_new_item' => __('Add New Summary Score'),
        'edit_item' => __('Edit Summary Score'),
        'new_item' => __('New Summary Score'),
        'all_items' => __('All Summary Score'),
        'view_item' => __('View Summary Score'),
        'search_items' => __('Search Summary Score'),
        'not_found' => __('No summary score found'),
        'not_found_in_trash' => __('No summary score found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Summary Score'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('s_score', $args);
   
 /** Register 'Developer' post type */
    $labels = array(
        'name' => _x('Developer', 'post type general name'),
        'singular_name' => _x('Developer', 'post type singular name'),
        'add_new' => _x('Add New', 'developer'),
        'add_new_item' => __('Add New Developer'),
        'edit_item' => __('Edit Developer'),
        'new_item' => __('New Developer'),
        'all_items' => __('All Developer'),
        'view_item' => __('View Developer'),
        'search_items' => __('Search Developer'),
        'not_found' => __('No developer found'),
        'not_found_in_trash' => __('No developer found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Developer'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('developer', $args);


    /** Register 'Basic Form' post type */
    $labels = array(
        'name' => _x('Basic Form', 'post type general name'),
        'singular_name' => _x('Basic Form', 'post type singular name'),
        'add_new' => _x('Add New', 'basic form'),
        'add_new_item' => __('Add New Basic Form'),
        'edit_item' => __('Edit Basic Form'),
        'new_item' => __('New Basic Form'),
        'all_items' => __('All Basic Form'),
        'view_item' => __('View Basic Form'),
        'search_items' => __('Search Basic Form'),
        'not_found' => __('No basic form found'),
        'not_found_in_trash' => __('No basic form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Basic Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('basic_form', $args);

 /** Register 'Privacy and Security' post type */
    $labels = array(
        'name' => _x('Privacy and Security Form', 'post type general name'),
        'singular_name' => _x('Privacy and Security Form', 'post type singular name'),
        'add_new' => _x('Add New', 'Privacy and Security form'),
        'add_new_item' => __('Add New Privacy and Security Form'),
        'edit_item' => __('Edit Privacy and Security Form'),
        'new_item' => __('New Privacy and Security Form'),
        'all_items' => __('All Privacy and Security Form'),
        'view_item' => __('View Privacy and Security Form'),
        'search_items' => __('Search Privacy and Security Form'),
        'not_found' => __('No Privacy and Security form found'),
        'not_found_in_trash' => __('No Privacy and Security form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Privacy and Security Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('ps_form', $args);

 /** Register 'Safety' post type */
    $labels = array(
        'name' => _x('Safety Form', 'post type general name'),
        'singular_name' => _x('Safety Form', 'post type singular name'),
        'add_new' => _x('Add New', 'Safety form'),
        'add_new_item' => __('Add New Safety Form'),
        'edit_item' => __('Edit Safety Form'),
        'new_item' => __('New Safety Form'),
        'all_items' => __('All Safety Form'),
        'view_item' => __('View Safety Form'),
        'search_items' => __('Search Safety Form'),
        'not_found' => __('No Safety form found'),
        'not_found_in_trash' => __('No Safety form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Safety Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('safety_form', $args);
    
   /** Register 'Interoperability Form' post type */
    $labels = array(
        'name' => _x('Interoperability Form', 'post type general name'),
        'singular_name' => _x('Interoperability Form', 'post type singular name'),
        'add_new' => _x('Add New', 'Interoperability form'),
        'add_new_item' => __('Add New Interoperability Form'),
        'edit_item' => __('Edit Interoperability Form'),
        'new_item' => __('New Interoperability Form'),
        'all_items' => __('All Interoperability Form'),
        'view_item' => __('View Interoperability Form'),
        'search_items' => __('Search Interoperability Form'),
        'not_found' => __('No Interoperability form found'),
        'not_found_in_trash' => __('No Interoperability form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Interoperability Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('io_form', $args);  

 /** Register 'Open Data Form' post type */
    $labels = array(
        'name' => _x('Open Data Form', 'post type general name'),
        'singular_name' => _x('Open Data Form', 'post type singular name'),
        'add_new' => _x('Add New', 'Open Data form'),
        'add_new_item' => __('Add New Open Data Form'),
        'edit_item' => __('Edit Open Data Form'),
        'new_item' => __('New Open Data Form'),
        'all_items' => __('All Open Data Form'),
        'view_item' => __('View IOpen Data Form'),
        'search_items' => __('Search Open Data Form'),
        'not_found' => __('No Open Data form found'),
        'not_found_in_trash' => __('No Open Data form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Open Data Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('od_form', $args);      
    
 /** Register 'Equality Form' post type */
    $labels = array(
        'name' => _x('Equality Form', 'post type general name'),
        'singular_name' => _x('Equality Form', 'post type singular name'),
        'add_new' => _x('Add New', 'Equality form'),
        'add_new_item' => __('Add New Equality Form'),
        'edit_item' => __('Edit Equality Form'),
        'new_item' => __('New Equality Form'),
        'all_items' => __('All Equality Form'),
        'view_item' => __('View Equality Form'),
        'search_items' => __('Search Equality Form'),
        'not_found' => __('No Equality form found'),
        'not_found_in_trash' => __('No Equality form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Equality Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('equality_form', $args);
    
  /** Register 'Quality and Usability Form' post type */
 /** Changed to just Usability on 22 Aug */
    $labels = array(
        'name' => _x('Usability Form', 'post type general name'),
        'singular_name' => _x('Usability Form', 'post type singular name'),
        'add_new' => _x('Add New', 'Usability form'),
        'add_new_item' => __('Add New Usability Form'),
        'edit_item' => __('Edit Usability Form'),
        'new_item' => __('New Usability Form'),
        'all_items' => __('All Usability Form'),
        'view_item' => __('View Usability Form'),
        'search_items' => __('Search Usability Form'),
        'not_found' => __('No Usability form found'),
        'not_found_in_trash' => __('No Usability form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Usability Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('qu_form', $args);

 /** Register 'Technical Stability Form' post type */
    $labels = array(
        'name' => _x('Technical Stability Form', 'post type general name'),
        'singular_name' => _x('Technical Stability Form', 'post type singular name'),
        'add_new' => _x('Add New', 'Technical Stability Form'),
        'add_new_item' => __('Add Technical Stability Form'),
        'edit_item' => __('Edit Technical Stability Form'),
        'new_item' => __('New Technical Stability Form'),
        'all_items' => __('All Technical Stability Form'),
        'view_item' => __('View Technical Stability Form'),
        'search_items' => __('Search Technical Stability Form'),
        'not_found' => __('No Technical Stability Form found'),
        'not_found_in_trash' => __('No Technical Stability Form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Technical Stability Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('ts_form', $args);
   
 /** Register 'Effectiveness Form' post type */
    $labels = array(
        'name' => _x('Effectiveness Form', 'post type general name'),
        'singular_name' => _x('Effectiveness Form', 'post type singular name'),
        'add_new' => _x('Add New', 'Effectiveness form'),
        'add_new_item' => __('Add New Effectiveness Form'),
        'edit_item' => __('Edit Effectiveness Form'),
        'new_item' => __('New Effectiveness Form'),
        'all_items' => __('All Effectiveness Form'),
        'view_item' => __('View Effectiveness Form'),
        'search_items' => __('Search Effectiveness Form'),
        'not_found' => __('No Effectiveness form found'),
        'not_found_in_trash' => __('No Effectiveness form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Effectiveness Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('eff_form', $args);



    
     /** Register 'Registration Form' post type */
    $labels = array(
        'name' => _x('Registration Form', 'post type general name'),
        'singular_name' => _x('Registration Form', 'post type singular name'),
        'add_new' => _x('Add New', 'Registration Form'),
        'add_new_item' => __('Add Registration Form'),
        'edit_item' => __('Edit Registration Form'),
        'new_item' => __('New Registration Form'),
        'all_items' => __('All Registration Form'),
        'view_item' => __('View Registration Form'),
        'search_items' => __('Search Registration Form'),
        'not_found' => __('No Registration Form found'),
        'not_found_in_trash' => __('No Registration Form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Registration Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('reg_form', $args);



    /** Register 'Application Name' taxonomy */
    $labels = array(
        'name' => _x('Application Names', 'taxonomy general name'),
        'singular_name' => _x('Application Name', 'taxonomy singular name'),
        'search_items' => __('Search Application Names'),
        'popular_items' => __('Popular Application Names'),
        'all_items' => __('All Application Names'),
        'parent_item' => NULL,
        'parent_item_colon' => NULL,
        'edit_item' => __('Edit Application Name'),
        'update_item' => __('Update Application Name'),
        'add_new_item' => __('Add New Application Name'),
        'new_item_name' => __('New Application Name'),
        'separate_items_with_commas' => __('Separate application names with commas'),
        'add_or_remove_items' => __('Add or remove application names'),
        'choose_from_most_used' => __('Choose from the most used application names'),
        'menu_name' => __('Application Name'),
    );
    register_taxonomy(
        'app_name',
        array('developer', 'basic_form', 'ps_form', 'safety_form', 'od_form', 'equality_form', 'io_form', 'eff_form', 'trans_form', 'ts_form', 'reg_form'),
        array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
        ));

  /** Register 'Transparency Form' post type */
 /** Removal on 22 Aug save questions??
    $labels = array(
        'name' => _x('Transparency Form', 'post type general name'),
        'singular_name' => _x('Transparency Form', 'post type singular name'),
        'add_new' => _x('Add New', 'Transparency form'),
        'add_new_item' => __('Add New Transparency Form'),
        'edit_item' => __('Edit Transparency Form'),
        'new_item' => __('New Transparency Form'),
        'all_items' => __('All Transparency Form'),
        'view_item' => __('View Transparency Form'),
        'search_items' => __('Search Transparency Form'),
        'not_found' => __('No Transparency form found'),
        'not_found_in_trash' => __('No Transparency form found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Transparency Form'
    );
    $args = array(
     'labels' => $labels,
      'public' => true,
     'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
     'query_var' => true,
      'rewrite' => true,
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => NULL,
      'taxonomies' => array('team_tag'),
      'supports' => array('title', 'editor')
  );
    if (constant('IS_SUPERADMIN_MODE') == true) $args['supports'][] = 'custom-fields';
    register_post_type('trans_form', $args);*/

   
 
    /** Custom 'Editor' user privileges */
   /*
 $caps = get_editor_caps();
    remove_role('editor');
    add_role("editor", "Editor", $caps);
*/

    /** Flush permalinks when in admin area */
    if (is_admin()):
        $wp_rewrite->flush_rules();
    endif;
}

function custom_admin_menu()
{
    global $menu, $submenu;
    //if (constant('IS_SUPERADMIN_MODE') == true) return;

    //REMOVE SOME MENU ITEMS UNLESS SUPER ADMIN MODE IS ENABLED
     remove_menu_page('edit-comments.php');
	 unset($submenu['edit-comments.php']); //Removes comments submenu items
	 remove_menu_page('upload.php'); // remove media menu item
	 remove_menu_page('edit.php'); // remove News/Posts menu item
	 //unset($submenu['plugins.php']); //Removes plugins submenu items
	 //unset($submenu['edit.php'][15]); //Removes categories
    // unset($submenu['themes.php']); //Removes themes
    // unset($submenu['plugins.php']); //Removes plugins submenu items
 }  

   /*
function custom_pre_get_posts($query)
{
    global $wp_page;
    if (is_admin()):
        global $pagenow;
        if ('edit.php' == $pagenow && (get_query_var('post_type') && 'page' == get_query_var('post_type'))):
            $query->set('post__not_in', array(AJAX_PAGE)); //array of page id's to hide
        endif;
        if ($query->query_vars['post_type'] == 'player'):
            $query->set('meta_key', 'lastname');
            $query->set('order', 'asc');
            $query->set('orderby', 'meta_value');
        endif;
    else:
        if ($query->is_archive && !empty($query->query_vars['team'])):
            $query->set('meta_key', 'lastname');
            $query->set('order', 'asc');
            $query->set('orderby', 'meta_value');
        elseif (is_page(NEWS_PAGE)):
            $wp_page = $query;
            $args = array(
                'post_type' => 'post',
            );
            query_posts($args);
        elseif ($query->is_search):
            $query->set('post_type', array('post', 'match-report'));
            $query->set('posts_per_page', 10);
        endif;
    endif;
    return $query;
}

function custom_wp_dashboard_setup()
{
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['w3tc_latest']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['w3tc_pagespeed']);
    unset($wp_meta_boxes['dashboard']['side']['core']['feedwordpress_dashboard']);
}

function custom_admin_bar_menu()
{
    global $wp_admin_bar, $wpdb;
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('updates');
    $wp_admin_bar->remove_menu('site-name');
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('w3tc');
    $wp_admin_bar->remove_menu('new-content');
}
*/
