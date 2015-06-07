<?php
/**
 * The Template for displaying Lost Password form
 *
 * Override template in your theme by copying it to:
 * YOUR_THEME_DIR/templates/profile.php
 * or YOUR_THEME_DIR/templates/st-user/profile.php
 * or YOUR_THEME_DIR/st-user/profile.php
 *
 * @package 	ST-User/Templates
 * @version     1.0
 */


if( !is_user_logged_in() ){

}else{
    $user = wp_get_current_user();
?>
<div class="st-user-profile st-form-w">
    <h3><?php _e('Profile','st-user'); ?></h3>
    <form class="st-form st-form-profile" action="<?php echo site_url('/'); ?>" method="post" >

        <p class="st-user-msg <?php echo isset( $_REQUEST['st_profile_updated'] ) &&  $_REQUEST['st_profile_updated']  == 1 ? 'st-show' : ''; ?>"><?php _e('Your profile updated.', 'st-user'); ?></p>
        <p class="st-user-msg st-errors-msg"></p>
        <div class="form-fields">
            <p class="fieldset st-username">
                <label class="image-replace st-username" for="signin-password"><?php _e('User Name','st-user'); ?></label>
                <input value="<?php echo esc_attr( $user->user_login ); ?>" readonly="readonly" class="input full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr__('Your username','sa-login') ; ?>">
            </p>

            <p class="fieldset st-email">
                <label class="image-replace st-email" for="signup-email"><?php _e('E-mail', 'st-user'); ?></label>
                <input name="st_user_data[user_email]" value="<?php echo esc_attr(  $user->user_email ); ?>" class="full-width has-padding has-border" id="signup-email" type="email" placeholder="<?php echo esc_attr__('E-mail','st-user'); ?>">
                <span class="st-error-message"></span>
            </p>

            <p class="fieldset st-firstname">
                <label class="image-replace st-username" for="signin-password"><?php _e('First Name','st-user'); ?></label>
                <input name="st_user_data[user_firstname]" value="<?php echo esc_attr(  get_user_meta(  $user->ID, 'first_name', true ) ); ?>" class="input full-width has-padding has-border" type="text"  placeholder="<?php echo esc_attr__('First name','sa-login') ; ?>">
            </p>
            <p class="fieldset st-lastname">
                <label class="image-replace st-username" for="signin-password"><?php _e('Last Name','st-user'); ?></label>
                <input name="st_user_data[user_lastname]" value="<?php echo esc_attr( get_user_meta(  $user->ID, 'last_name', true ) ); ?>" class="input full-width has-padding has-border"  type="text"  placeholder="<?php echo esc_attr__('Last name','sa-login') ; ?>">
            </p>

            <p class="fieldset st-display-name">
                <label class="image-replace st-username" for="signin-password"><?php _e('Display Name','st-user'); ?></label>
                <input name="st_user_data[display_name]" value="<?php echo esc_attr(  $user->display_name ); ?>" class="input full-width has-padding has-border"  type="text"  placeholder="<?php echo esc_attr__('Display name','sa-login') ; ?>">
            </p>

            <p class="fieldset st-website">
                <label class="image-replace st-website" for="signin-password"><?php _e('Website','st-user'); ?></label>
                <input name="st_user_data[user_url]" value="<?php echo esc_attr(  $user->user_url ); ?>" class="input full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr__('Website','sa-login') ; ?>">
            </p>

            <p class="fieldset st-pwd pass1">
                <label class="image-replace st-password" for="signin-password"><?php _e('New Password','st-user'); ?></label>
                <input name="st_user_data[user_pass]" autocomplete="off" class="input full-width has-padding has-border" id="signin-password" type="password"  placeholder="<?php echo esc_attr__('New Password','sa-login') ; ?>">
                <a href="#0" class="hide-password"><?php _e('Show','st-user') ?></a>
                <span class="st-error-message"></span>
            </p>
            <p class="fieldset st-pwd pass2">
                <label class="image-replace st-password" for="signin-password"><?php _e('Comfirm New Password','st-user'); ?></label>
                <input name="st_user_pwd2" autocomplete="off" class="input full-width has-padding has-border" id="signin-password" type="password"  placeholder="<?php echo esc_attr__('Confirm New Password','sa-login') ; ?>">
                <a href="#0" class="hide-password"><?php _e('Show','st-user') ?></a>
                <span class="st-error-message"></span>
            </p>
            <?php

            /**
             * Hook to add more setting for profile if want
             */
            do_action('st_user_profile_more_fields');
            ?>
            <p class="fieldset">
                <input class="full-width has-padding st-submit" type="submit" data-loading-text="<?php echo esc_attr__('Loading...', 'st-user'); ?>" value="<?php echo esc_attr__('Update Profile','st-user'); ?>">
            </p>
        </div>
    </form>
</div>
<?php } ?>