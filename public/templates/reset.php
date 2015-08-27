<?php
/**
* The Template for displaying Reset form
*
* Override template in your theme by copying it to:
* YOUR_THEME_DIR/templates/reset.php
* or YOUR_THEME_DIR/templates/st-user/reset.php
* or YOUR_THEME_DIR/st-user/reset.php
*
* @package 	ST-User/Templates
* @version     1.0
*/
if ( !isset( $in_modal ) ) {
    $in_modal = false;
}
$id = uniqid('f');
?>
<form  id="st-reset-password" class="st-form st-form-reset-password" action="" method="post" >
    <?php if( ST_User()->settings['form_reset_header'] ) { ?>
    <div class="st-form-header">
        <h3><?php _e('Reset your password', 'st-user'); ?></h3>
    </div>
    <?php } ?>

    <div class="st-form-body">
        <p class="st-form-message"><?php _e( 'Please enter your email address. You will receive a link to create a new password.', 'st-user' ); ?></p>
        <p class="st-user-msg"><?php _e( 'Check your e-mail for the confirmation link.', 'st-user' ); ?></p>
        <div class="form-fields">
            <p class="fieldset st_input_combo">
                <label class="st-email" for="reset-email<?php echo $id; ?>"><?php _e('User name or E-mail', 'st-user' ); ?></label>
                <input name="st_user_login" class="full-width has-padding has-border" id="reset-email<?php echo $id; ?>" type="text" placeholder="<?php echo esc_attr__( 'User name or E-mail', 'st-user'); ?>">
                <span class="st-error-message"></span>
            </p>
            <p class="fieldset">
                <input class="full-width has-padding st-submit" data-loading-text="<?php echo esc_attr__( 'Loading...', 'st-user' ); ?>" type="submit" value="<?php echo esc_attr__( 'Submit', 'st-user' ); ?>">
            </p>
        </div>
    </div>
    <div class="st-form-footer">
        <p><?php printf( __( 'Remember your password ? <a class="st-back-to-login" href="%1$s">Login</a>', 'st-user' ), wp_login_url() ); ?></p>
    </div>
</form>