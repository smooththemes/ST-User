<?php
/**
 * The Template for displaying Register form
 *
 * Override template in your theme by copying it to:
 * YOUR_THEME_DIR/templates/register.php
 * or YOUR_THEME_DIR/templates/st-user/register.php
 * or YOUR_THEME_DIR/st-user/register.php
 *
 * @package 	ST-User/Templates
 * @version     1.0
 */
//global $custom_data;
//var_dump($custom_data, $a, $in_modal);
if ( !isset( $in_modal ) ) {
    $in_modal = false;
}
?>

<form id="st-signup" class="st-form st-register-form<?php echo $in_modal ? ' in-st-modal' : ''; ?>"  action="<?php echo site_url('/'); ?>" method="post">
    <div class="st-form-header">
        <h3><?php _e( 'Singup', 'st-user' ); ?></h3>
    </div>

    <div class="st-form-body">

        <p class="st-user-msg">
            <?php echo sprintf( __( 'Registration complete ! <a class="st-login-link" href="%1$s" title="Login">Click here to login</a> ', 'st-user' ), apply_filters( 'st_login_url', '#' ) ); ?>
        </p>
        <div class="form-fields">
            <?php do_action( 'st_user_before_register_form' ); ?>
            <p class="fieldset st_username">
                <label class="image-replace st-username" for="signup-username"><?php _e( 'Username', 'st-user' ) ?></label>
                <input name="st_signup_username" class="full-width has-padding has-border" id="signup-username" type="text" placeholder="<?php echo esc_attr__('Username', 'st-user'); ?>">
                <span class="st-error-message"></span>
            </p>

            <p class="fieldset st_email">
                <label class="image-replace st-email" for="signup-email"><?php _e( 'E-mail', 'st-user' ); ?></label>
                <input name="st_signup_email" class="full-width has-padding has-border" id="signup-email" type="email" placeholder="<?php echo esc_attr__('E-mail','st-user'); ?>">
                <span class="st-error-message"></span>
            </p>

            <p class="fieldset st_password">
                <label class="image-replace st-password" for="signup-password"><?php _e('Password','st-user') ?></label>
                <input name="st_signup_password" class="full-width has-padding has-border" id="signup-password" type="password"  placeholder="<?php echo esc_attr__('Password', 'st-user'); ?>">
                <a href="#" class="hide-password"><?php _e('Show','st-user') ?></a>
                <span class="st-error-message"></span>
            </p>
            <?php do_action( 'st_after_before_register_form' ); ?>
            <?php
            // Filter  to show term link
            $show_term =  apply_filters( 'st_user_term_link', '' ) != '' ? true : false;
            if ( apply_filters( 'st_user_register_show_term_link' , $show_term ) ) {
                ?>
                <p class="fieldset accept_terms">
                    <label><input name="st_accept_terms" value="i-agree" type="checkbox" id="st-accept-terms"> <?php echo sprintf( __( 'I agree to the <a href="%s" target="_blank">Terms and Conditions</a>', 'st-user' ),  apply_filters( 'st_user_term_link' , '#' ) ); ?></label>

                    <span class="st-error-message"><?php _e('You must agree our Terms and Conditions to continue', 'st-user'); ?></span>
                </p>
            <?php } ?>
            <p class="fieldset">
                <input class="st-submit full-width has-padding"  type="submit" data-loading-text="<?php echo esc_attr__( 'Loading...', 'st-user' ); ?>" value="<?php echo esc_attr__( 'Create account', 'st-user' ); ?>">
            </p>
        </div>

    </div>

    <div class="st-form-footer">
        <p>
            <?php
            printf( __( 'Already have an account ? <a class="st-back-to-login" href="%1$s">Login</a>', 'st-user' ), wp_login_url() );
            ?>
        </p>
    </div>
</form>
