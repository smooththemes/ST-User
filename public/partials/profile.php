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

?>
<div class="st-user-profile">
    <form class="st-form st-form-change-password<?php echo $in_modal ? ' in-st-modal' : ''; ?>" action="<?php echo site_url('/'); ?>" method="post" >

        <div class="form-fields">
            <p class="fieldset st-username">
                <label class="image-replace st-username" for="signin-password"><?php _e('User Name','st-user'); ?></label>
                <input name="st_pwd" class="input full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr__('Your username','sa-login') ; ?>">
            </p>

            <p class="fieldset st-email">
                <label class="image-replace st-email" for="signup-email"><?php _e('E-mail', 'st-user'); ?></label>
                <input name="st_signup_email" class="full-width has-padding has-border" id="signup-email" type="email" placeholder="<?php echo esc_attr__('E-mail','st-user'); ?>">
                <span class="st-error-message"></span>
            </p>

            <p class="fieldset st-username">
                <label class="image-replace st-username" for="signin-password"><?php _e('First Name','st-user'); ?></label>
                <input name="st_pwd" class="input full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr__('First name','sa-login') ; ?>">
            </p>
            <p class="fieldset st-username">
                <label class="image-replace st-username" for="signin-password"><?php _e('Last Name','st-user'); ?></label>
                <input name="st_pwd" class="input full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr__('Last name','sa-login') ; ?>">
            </p>

            <p class="fieldset st-website">
                <label class="image-replace st-website" for="signin-password"><?php _e('Website','st-user'); ?></label>
                <input name="st_pwd" class="input full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr__('Website','sa-login') ; ?>">
            </p>

            <p class="fieldset st-pwd pass1">
                <label class="image-replace st-password" for="signin-password"><?php _e('New Password','st-user'); ?></label>
                <input name="st_pwd" class="input full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr__('New Password','sa-login') ; ?>">
                <a href="#0" class="hide-password"><?php _e('Hide','st-user') ?></a>
                <span class="st-error-message"></span>
            </p>
            <p class="fieldset st-pwd pass2">
                <label class="image-replace st-password" for="signin-password"><?php _e('Comfirm New Password','st-user'); ?></label>
                <input name="st_pwd2" class="input full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr__('Confirm New Password','sa-login') ; ?>">
                <a href="#0" class="hide-password"><?php _e('Hide','st-user') ?></a>
                <span class="st-error-message"></span>
            </p>
            <p class="fieldset">
                <input class="full-width has-padding st-submit" type="submit" data-loading-text="<?php echo esc_attr__('Loading...', 'st-user'); ?>" value="<?php echo esc_attr__('Reset password','st-user'); ?>">
            </p>
        </div>
    </form>
</div>