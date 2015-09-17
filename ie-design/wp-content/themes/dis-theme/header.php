<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<?php include("inc/meta.php"); ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>
<?php 
myStartSession();	
	if(isset($_GET['logout'])) {
	myEndSession();
}
elseif(isset($_GET['new_app'])) {
	unset($_SESSION['app_id']);
	unset($_SESSION['basic_form_id']);
}

	

?>
</head>

<body <?php body_class($containerClass); ?> id="wordpress">
	 <div id="topbar">
		 <?php if ($_SESSION['developer_id']){ ?>
		 <div class="container">
			<a class="btn btn-success pull-left" href="/ie-design/the-basics?new_app=true">Start a new app <i class="fa fa-plus-circle"></i></a> 
			&nbsp;&nbsp;<a class="btn btn-warning" href="/ie-design/your-apps">My Apps <i class="fa fa-mobile"></i></a> 
		 	<a class="btn btn-primary pull-right" href="/ie-design/?logout=true">Logout <i class="fa fa-lock"></i></a>
		 </div>
		 <?php }?>
		 
		     </div>
		    



