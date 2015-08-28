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
if ( !isset( $in_modal ) ) {
    $in_modal = false;
}

if ( ! isset ( $login_redirect_url ) ) {
    $login_redirect_url = '';
}

$id = uniqid('f');

if ( ! is_user_logged_in() ) {
?>

<form id="st-login" class="st-form st-login-form" action="<?php echo site_url('/'); ?>" method="post">
    <?php if( ST_User()->settings['form_login_header'] ) { ?>
    <div class="st-form-header">
        <h3><?php _e( 'Login', 'st-user' ); ?></h3>
    </div>
    <?php } ?>

    <div class="st-form-body">
        <?php do_action( 'st_user_before_login_form' ); ?>
        <p class="fieldset st_username_email">
            <label class="st-username" for="signin-username<?php echo $id; ?>"><?php _e( 'Username or email', 'st-user' ); ?></label>
            <input name="st_username" class="full-width has-padding has-border" id="signin-username<?php echo $id; ?>" type="text" placeholder="<?php echo esc_attr( __( 'Username or email', 'st-user' ) ); ?>">
            <span class="st-error-message"></span>
        </p>

        <p class="fieldset st_pwd">
            <label class="image-replace st-password" for="signin-password<?php echo $id; ?>"><?php _e('Password','st-user'); ?></label>
            <input name="st_pwd" class="full-width has-padding has-border" id="signin-password<?php echo $id; ?>" type="password"  placeholder="<?php echo esc_attr( __( 'Password', 'st-user' ) ); ?>">
            <a href="#0" class="hide-password"><?php _e( 'Show', 'st-user' ) ?></a>
            <span class="st-error-message"></span>
        </p>
        <p class="forgetmenot fieldset">
            <label> <input type="checkbox" value="forever" name="st-rememberme" checked> <?php _e( 'Remember me','st-user' ); ?></label>
            <a class="st-lost-pwd-link" href="<?php echo wp_lostpassword_url(); ?>"><?php _e( 'Forgot password ?', 'st-user' ); ?></a>
        </p>
        <?php do_action('st_user_before_submit_login_form'); ?>
        <p class="fieldset">
            <input class="full-width" type="submit" value="<?php echo esc_attr__( 'Login', 'st-user' ); ?>">
            <input type="hidden" value="<?php echo apply_filters( 'st_user_logged_in_redirect_to', $login_redirect_url ); ?>" name="st_redirect_to" >
        </p>

        <?php do_action('st_user_after_login_form', $in_modal, $login_redirect_url ); ?>
    </div>

    <div class="st-form-footer">
        <p>
        <?php
            printf( __( 'Don\'t have an account ? <a  class="st-register-link" href="%1$s">Sing Up</a>', 'st-user'  ), wp_registration_url() );
        ?>
        </p>
    </div>
</form>

<?php } else {

    // user logged in info
    $user = wp_get_current_user();
    ?>

    <div class="st-logged-in st-profile-mini" >
        <div class="st-form-header">
            <?php do_action( 'st_user_profile_header' , $user, false , false );  ?>
        </div>
        <div class="st-form-body st-user-links">
            <a href="<?php echo ST_User()->get_profile_link( $user ); ?>"><?php _e( 'Profile', 'st-user' ) ?></a>
            <a href="<?php echo wp_logout_url() ; ?>"><?php _e( 'Logout', 'st-user' ) ?></a>
            <?php do_action( 'st_user_logged_in_links',  $user ); ?>
        </div>
    </div>

<?php }?>