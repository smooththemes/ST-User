<div id="st-signup"> <!-- sign up form -->
    <form class="st-form st-register-form" action="<?php echo get_permalink(); ?>" method="post">
        <p class="fieldset st-username">
            <label class="image-replace " for="signup-username"><?php _e('Username','st-user') ?></label>
            <input name="st_signup_username" class="full-width has-padding has-border" id="signup-username" type="text" placeholder="<?php echo esc_attr__('Username', 'st-user'); ?>">
            <span class="st-error-message"></span>
        </p>

        <p class="fieldset st-email">
            <label class="image-replace " for="signup-email"><?php _e('E-mail', 'st-user'); ?></label>
            <input name="st_signup_email" class="full-width has-padding has-border" id="signup-email" type="email" placeholder="<?php echo esc_attr__('E-mail','st-user'); ?>">
            <span class="st-error-message"></span>
        </p>

        <p class="fieldset st-password">
            <label class="image-replace " for="signup-password"><?php _e('Password','st-user') ?></label>
            <input name="st_signup_password" class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="<?php echo esc_attr__('Password', 'st-user'); ?>">
            <a href="#" class="hide-password"><?php _e('Hide','st-mail') ?></a>
            <span class="st-error-message"></span>
        </p>

        <p class="fieldset accept-terms">
            <label><input name="st_accept_terms" type="checkbox" id="accept-terms"> I agree to the <a href="#">Terms</a></label>
        </p>

        <p class="fieldset">
            <input class="full-width has-padding" type="submit" value="<?php echo esc_attr__('Create account', 'st-user'); ?>">
        </p>
    </form>

    <!-- <a href="#0" class="st-close-form">Close</a> -->
</div> <!-- st-signup -->