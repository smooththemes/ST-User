<div id="st-login"> <!-- log in form -->
    <form class="st-form st-login-form" action="<?php echo get_permalink(); ?>" method="post">
        <p class="fieldset">
            <label class="image-replace st-email" for="signin-username"><?php _e('Username','st-user'); ?></label>
            <input name="st-username" class="full-width has-padding has-border" id="signin-username" type="text" placeholder="<?php echo esc_attr( __('Username', 'st-login')); ?>">
            <span class="st-error-message">Error message here!</span>
        </p>

        <p class="fieldset">
            <label class="image-replace st-password" for="signin-password"><?php _e('Password','st-user'); ?></label>
            <input name="st-pwd" class="full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr( __('Password','sa-login') ); ?>">
            <a href="#0" class="hide-password"><?php _e('Hide','st-user') ?></a>
            <span class="st-error-message">Error message here!</span>
        </p>

        <p class="forgetmenot fieldset">
            <label> <input type="checkbox" value="forever" name="st-rememberme" checked><?php _e('Remember me','st-user'); ?></label>
        </p>

        <p class="fieldset">
            <input class="full-width" type="submit" value="<?php echo esc_attr__('Login', 'st-user'); ?>">
        </p>
    </form>

    <p class="st-form-bottom-message"><a href="#0"><?php _e('Forgot your password?','st-user'); ?></a></p>
    <!-- <a href="#0" class="st-close-form">Close</a> -->
</div> <!-- st-login -->