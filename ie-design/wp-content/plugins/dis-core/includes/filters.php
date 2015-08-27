<?php


//GENERIC
function custom_admin_footer_text() {
	echo 'Created by <a href="http://www.doitsimply.co.uk/" target="_blank">do it simply</a>. ';
	echo 'Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a>.';
}

function custom_post_columns($defaults) {
	if(constant('IS_SUPERADMIN_MODE') == true) return $defaults;
	unset($defaults['categories']);
	unset($defaults['comments']);
	unset($defaults['author']);
	unset($defaults['date']);
	unset($defaults['post_thumb']);
	return $defaults;
}

function custom_pages_columns($defaults) {
	if(constant('IS_SUPERADMIN_MODE') == true) return $defaults;
	unset($defaults['post_thumb']);
	unset($defaults['comments']);
	unset($defaults['author']);
	unset($defaults['date']);
	return $defaults;
}

function custom_media_columns($defaults) {
	if(constant('IS_SUPERADMIN_MODE') == true) return $defaults;
	unset($defaults['comments']);
	unset($defaults['author']);
	unset($defaults['date']);
	unset($defaults['media_tags']);
	return $defaults;
}

function custom_player_columns($defaults) {
	if(constant('IS_SUPERADMIN_MODE') == true) return $defaults;
	unset($defaults['attachment_count']);
	unset($defaults['hsm_pagetitle']);
	unset($defaults['hsm_description']);
	return $defaults;
}

function custom_team_columns($defaults) {
	if(constant('IS_SUPERADMIN_MODE') == true) return $defaults;
	unset($defaults['posts']);
	return $defaults;
}

function custom_upload_views($defaults) {
	return $defaults;
}

function custom_favorite_actions($defaults) {
	return $defaults;
}

function custom_user_has_cap($allcaps, $cap, $args) {
	if(constant('IS_SUPERADMIN_MODE') == true) return $allcaps;
	unset($allcaps['switch_themes']);
	unset($allcaps['edit_themes']);
	unset($allcaps['activate_plugins']);
	unset($allcaps['edit_plugins']);
	unset($allcaps['switch_themes']);
	unset($allcaps['update_plugins']);
	unset($allcaps['delete_plugins']);
	unset($allcaps['install_plugins']);
	unset($allcaps['update_themes']);
	unset($allcaps['install_themes']);
	unset($allcaps['update_core']);
	unset($allcaps['delete_themes']);
	unset($allcaps['NextGEN Manage tags']);
	unset($allcaps['NextGEN Change style']);
	unset($allcaps['NextGEN Change options']);
	return $allcaps;
}

function custom_upload_mimes($existing_mimes = array()) {
	return $existing_mimes;
}

function custom_title_save_pre($title) {
	if(!empty($_POST) && $_POST['post_type'] == 'fixture'):
		$tags = $_POST['rd2_mtc_tags'];
		$tag  = '';
		if(count($tags) && false):
			$term = reset($tags);
			$term = get_term($term, 'team');
			$tag  = ' (' . $term->name . ')';
		endif;
	return $_POST['fields']['field_40'] . ' v ' . $_POST['fields']['field_41'] . ' - ' . $_POST['fields']['field_42'] . $tag;
	endif
	;
	return $title;
}

function custom_desktop_wp_nav_menu($pageList) {
	$allLisPattern = '/<li(.*)<\/li>/s';
	preg_match($allLisPattern, $pageList, $allLis);
	$liClassPattern = "/<li[^>]+class=\"([^\"]+)/i";
	$liArray        = explode("\n", $allLis[0]);
	$liArrayCount   = count($liArray);
	preg_match($liClassPattern, $liArray[0], $firstMatch);
	$newFirstLi = str_replace($firstMatch[1], $firstMatch[1] . " first-menu-item", $liArray[0]);
	if($liArrayCount > 1):
		$lastLiPosition = $liArrayCount - 1;
		preg_match($liClassPattern, $liArray[$lastLiPosition], $lastMatch);
		$newFirstLi = str_replace($firstMatch[1], $firstMatch[1] . " first-menu-item", $liArray[0]);
		$newLastLi  = str_replace($lastMatch[1], $lastMatch[1] . " last-menu-item", $liArray[$lastLiPosition]);
	endif;
	$newPageList = $newFirstLi . '';
	$i           = 1;
	while($i < $lastLiPosition):
		$newPageList .= $liArray[$i];
		$i++;
	endwhile;
	$newPageList .= $newLastLi;
	$pageList = str_replace($allLis[0], $newPageList, $pageList);
	return $pageList;
} 

//DESKTOP
function custom_desktop_excerpt_length($length) {
	global $post;
	if($post->post_type == 'people'):
		return 30;
	elseif(is_page(HOME_PAGE)):
		return 10;
	else:
		return 40;
	endif;
}
function custom_desktop_excerpt_more($more) {
	//return '&hellip;' . custom_desktop_continue_reading_link();
}
