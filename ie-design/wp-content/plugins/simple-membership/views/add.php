<div class="swpm-registration-widget-form">
<form id="swpm-registration-form" name="swpm-registration-form" method="post" action="">
    <input type ="hidden" name="level_identifier" value="<?php echo  $level_identifier?>" />
    <div class="form-group">
	    <label for="user_name"><?php echo  SwpmUtils::_('User Name') ?></label>
        <input type="text" id="user_name" class="validate[required,custom[noapostrophe],custom[SWPMUserName],minSize[4],ajax[ajaxUserCall]] form-control" value="<?php echo $user_name;?>" tabindex="1" size="50" name="user_name" />
	</div>
	<div class="form-group">
        <label for="email"><?php echo  SwpmUtils::_('Email') ?></label>
        <input type="text" id="email" class="validate[required,custom[email],ajax[ajaxEmailCall]] form-control" value="<?php echo $email;?>" tabindex="2" size="50" name="email" />
	</div>
	<div class="form-group">
        <label for="password"><?php echo  SwpmUtils::_('Password') ?></label>
        <input type="password" class="form-control" autocomplete="off" id="password" value="" tabindex="3" size="50" name="password" />
    <div class="form-group">
        <label for="password_re"><?php echo  SwpmUtils::_('Repeat Password') ?></label>
        <input class="form-control" type="password" autocomplete="off" id="password_re" value="" tabindex="4" size="50" name="password_re" />
    </div>
    <div class="form-group">
       <label for="first_name"><?php echo  SwpmUtils::_('First Name') ?></label>
       <input type="text" class="form-control" id="first_name" value="<?php echo $first_name;?>" tabindex="5" size="50" name="first_name" />
    </div>
    <div class="form-group">
        <label for="last_name"><?php echo  SwpmUtils::_('Last Name') ?></label>
        <input type="text"  class="form-control" id="last_name" value="<?php echo $last_name;?>" tabindex="6" size="50" name="last_name" />
    </div>
   
       <!-- <label for="membership_level"><?php echo  SwpmUtils::_('Membership Level') ?></label>
        
            <?php echo $membership_level_alias;?>-->
                <input type="hidden" value="<?php echo $membership_level;?>" size="50" name="membership_level" tabindex="7" id="membership_level" />
                     
    
    <p align="center"><input type="submit" value="<?php echo  SwpmUtils::_('Register') ?>" class="btn btn-success" tabindex="8" id="submit" name="swpm_registration_submit" /></p>
    <input type="hidden" name="action" value="custom_posts" />
    <?php wp_nonce_field( 'name_of_my_action','name_of_nonce_field' ); session_destroy(); ?>
</form>
</div>
<script>
jQuery(document).ready(function($){
    $.validationEngineLanguage.allRules['ajaxUserCall']['url']= '<?php echo admin_url('admin-ajax.php');?>';
    $.validationEngineLanguage.allRules['ajaxEmailCall']['url']= '<?php echo admin_url('admin-ajax.php');?>';
    $.validationEngineLanguage.allRules['ajaxEmailCall']['extraData'] = '&action=swpm_validate_email&member_id=<?php echo  filter_input(INPUT_GET, 'member_id');?>';
    $("#swpm-registration-form").validationEngine('attach');
});
</script>
