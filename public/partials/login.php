<?php
/**
 * The Template for displaying login form
 *
 * Override template in your theme by copying it to:
 * YOUR_THEME_DIR/templates/login.php
 * or YOUR_THEME_DIR/templates/st-user/login.php
 * or YOUR_THEME_DIR/st-user/login.php
 *
 * @package 	ST-User/Templates
 * @version     1.0
 */

?>

<div id="st-login"> <!-- log in form -->
    <form class="st-form st-login-form" action="<?php echo site_url('/'); ?>" method="post">
        <p class="fieldset st-username">
            <label class="image-replace st-email" for="signin-username"><?php _e('Username','st-user'); ?></label>
            <input name="st_username" class="full-width has-padding has-border" id="signin-username" type="text" placeholder="<?php echo esc_attr( __('Username', 'st-login')); ?>">
            <span class="st-error-message"></span>
        </p>

        <p class="fieldset st-pwd">
            <label class="image-replace st-password" for="signin-password"><?php _e('Password','st-user'); ?></label>
            <input name="st_pwd" class="full-width has-padding has-border" id="signin-password" type="password"  placeholder="<?php echo esc_attr( __('Password','sa-login') ); ?>">
            <a href="#0" class="hide-password"><?php _e('Show','st-user') ?></a>
            <span class="st-error-message"></span>
        </p>
        <p class="forgetmenot fieldset">
            <label> <input type="checkbox" value="forever" name="st-rememberme" checked> <?php _e('Remember me','st-user'); ?></label>
        </p>
        <p class="fieldset">
            <input class="full-width" type="submit" value="<?php echo esc_attr__('Login', 'st-user'); ?>">
            <input type="hidden" value="<?php echo apply_filters('st_user_logged_in_redirect_to', get_permalink() ); ?>" name="st_redirect_to" >
        </p>
    </form>
    <p class="st-form-bottom-message"><a href="#"><?php _e('I don\'t know my password','st-user'); ?></a></p>
    <!-- <a href="#0" class="st-close-form">Close</a> -->
</div> <!-- st-login -->