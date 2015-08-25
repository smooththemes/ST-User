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


$is_edit = ( isset( $_REQUEST['st_edit'] ) ) ?  true : false;

if ( !is_user_logged_in() ) {

} else {
    $user = wp_get_current_user();
?>
<div class="st-form st-form-profile" >

    <?php if( ST_User()->settings['form_profile_header'] ) {

        ?>
    <div class="st-form-header">
        <?php do_action( 'st_user_profile_header' , $user, $is_edit );  ?>
    </div>
    <?php } ?>

    <div class="st-form-body clear-fix">

        <?php do_action( 'st_user_profile_before_form_body', $user, $is_edit );  ?>

        <?php if ( !$is_edit ) { ?>
        <div class="st-form-profile clear-fix"  >

            <div class="form-fields viewing-info">
                <p class="fieldset st-username">
                    <label class=""><?php _e( 'User Name', 'st-user' ); ?></label>
                    <span>
                        <?php echo esc_html( $user->user_login ); ?>
                    </span>
                </p>

                <p class="fieldset st-email">
                    <label class=" "><?php _e( 'E-mail', 'st-user' ); ?></label>
                    <span>
                        <?php echo esc_html( $user->user_email ); ?>
                    </span>
                </p>

                <p class="fieldset st-firstname">
                    <label class=""><?php _e( 'First Name', 'st-user' ); ?></label>
                    <span class="">
                        <?php echo esc_html( get_user_meta( $user->ID, 'first_name', true ) ); ?>
                    </span>
                </p>
                <p class="fieldset st-lastname">
                    <label class=""><?php _e( 'Last Name', 'st-user' ); ?></label>
                    <span class="">
                        <?php echo  esc_html( get_user_meta( $user->ID, 'last_name', true ) ); ?>
                    </span>
                </p>

                <p class="fieldset">
                    <label class=""><?php _e( 'Display Name', 'st-user' ); ?></label>
                    <span><?php  echo esc_html( $user->display_name );  ?></span>
                </p>


                <p class="fieldset st-website">
                    <label class="" for="signin-password"><?php _e( 'Website', 'st-user' ); ?></label>
                    <span class="">
                        <?php echo esc_html( $user->user_url ); ?>
                    </span>
                </p>

                <p class="fieldset">
                    <label class=""><?php _e( 'Bio', 'st-user' ); ?></label>
                    <span>
                        <?php echo  esc_html( get_user_meta( $user->ID, 'description', true ) ); ?>
                    </span>
                </p>

            </div>
        </div>

        <?php  } else {  ?>

        <form class="st-form-profile" action="<?php echo site_url('/'); ?>" method="post" >
            <p class="st-user-msg <?php echo isset( $_REQUEST['st_profile_updated'] ) &&  $_REQUEST['st_profile_updated']  == 1 ? 'st-show' : ''; ?>"><?php _e( 'Your profile updated.', 'st-user' ); ?></p>
            <p class="st-user-msg st-errors-msg"></p>

            <div class="form-fields">
                <p class="fieldset st-username">
                    <label class="" for="signin-password"><?php _e( 'User Name', 'st-user' ); ?></label>
                    <input value="<?php echo esc_attr( $user->user_login ); ?>" readonly="readonly" class="input full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr__( 'Your username', 'st-user' ) ; ?>">
                </p>

                <p class="fieldset st-email">
                    <label class=" " for="signup-email"><?php _e( 'E-mail', 'st-user' ); ?></label>
                    <input name="st_user_data[user_email]" value="<?php echo esc_attr( $user->user_email ); ?>" class="full-width has-padding has-border" id="signup-email" type="email" placeholder="<?php echo esc_attr__( 'E-mail', 'st-user' ); ?>">
                    <span class="st-error-message"></span>
                </p>

                <p class="fieldset st-firstname">
                    <label class="" for="signin-password"><?php _e( 'First Name', 'st-user' ); ?></label>
                    <input name="st_user_data[first_name]" value="<?php echo esc_attr( get_user_meta( $user->ID, 'first_name', true ) ); ?>" class="input full-width has-padding has-border" type="text"  placeholder="<?php echo esc_attr__( 'First name', 'st-user' ) ; ?>">
                </p>

                <p class="fieldset st-lastname">
                    <label class="" for="signin-password"><?php _e( 'Last Name', 'st-user' ); ?></label>
                    <input name="st_user_data[last_name]" value="<?php echo esc_attr( get_user_meta( $user->ID, 'last_name', true ) ); ?>" class="input full-width has-padding has-border"  type="text"  placeholder="<?php echo esc_attr__('Last name','st-user') ; ?>">
                </p>

                <p class="fieldset st-display-name">
                    <label class=" " for="signin-password"><?php _e( 'Display Name', 'st-user' ); ?></label>
                    <input name="st_user_data[display_name]" value="<?php echo esc_attr( $user->display_name ); ?>" class="input full-width has-padding has-border"  type="text"  placeholder="<?php echo esc_attr__( 'Display name','st-user' ) ; ?>">
                </p>

                <p class="fieldset st-website">
                    <label class="" for="signin-password"><?php _e( 'Website', 'st-user' ); ?></label>
                    <input name="st_user_data[user_url]" value="<?php echo esc_attr( $user->user_url ); ?>" class="input full-width has-padding has-border" id="signin-password" type="text"  placeholder="<?php echo esc_attr__( 'Website', 'st-user' ) ; ?>">
                </p>

                <p class="fieldset st-pwd pass1">
                    <label class=" " for="signin-password"><?php _e( 'New Password', 'st-user' ); ?></label>
                    <input name="st_user_data[user_pass]" autocomplete="off" class="input full-width has-padding has-border" id="signin-password" type="password"  placeholder="<?php echo esc_attr__( 'New Password', 'st-user' ) ; ?>">
                    <a href="#0" class="hide-password"><?php _e('Show','st-user') ?></a>
                    <span class="st-error-message"></span>
                </p>
                <p class="fieldset st-pwd pass2">
                    <label class="" for="signin-password"><?php _e( 'Comfirm New Password', 'st-user' ); ?></label>
                    <input name="st_user_pwd2" autocomplete="off" class="input full-width has-padding has-border" id="signin-password" type="password"  placeholder="<?php echo esc_attr__( 'Confirm New Password','st-user' ) ; ?>">
                    <a href="#0" class="hide-password"><?php _e( 'Show', 'st-user' ) ?></a>
                    <span class="st-error-message"></span>
                </p>
                <p class="fieldset st-website">
                    <label class="" for="signin-password"><?php _e( 'Bio', 'st-user' ); ?></label>
                    <textarea name="st_user_data[description]"><?php echo esc_attr( get_user_meta( $user->ID, 'description', true ) ); ?></textarea>
                </p>
                <p class="fieldset st-firstname">
                    <label><?php _e( 'Facebook URL', 'st-user' ); ?></label>
                    <input name="st_user_data[facebook]" value="<?php echo esc_attr( get_user_meta( $user->ID, 'facebook', true ) ); ?>" class="input full-width has-padding has-border" type="text"  placeholder="<?php echo esc_attr__( 'Facebook URL', 'st-user' ) ; ?>">
                </p>
                <p class="fieldset st-firstname">
                    <label><?php _e( 'Twitter URL', 'st-user' ); ?></label>
                    <input name="st_user_data[twitter]" value="<?php echo esc_attr( get_user_meta( $user->ID, 'twitter', true ) ); ?>" class="input full-width has-padding has-border" type="text"  placeholder="<?php echo esc_attr__( 'Twitter URL', 'st-user' ) ; ?>">
                </p>
                <p class="fieldset st-firstname">
                    <label ><?php _e( 'Google+ URL', 'st-user' ); ?></label>
                    <input name="st_user_data[google]" value="<?php echo esc_attr( get_user_meta( $user->ID, 'google', true ) ); ?>" class="input full-width has-padding has-border" type="text"  placeholder="<?php echo esc_attr__( 'Google+ URL', 'st-user' ) ; ?>">
                </p>
                <?php

                /**
                 * Hook to add more setting for profile if want
                 */
                do_action( 'st_user_profile_more_fields', $user, $is_edit );
                ?>
                <p class="fieldset">
                    <input class="button btn" type="submit" data-loading-text="<?php echo esc_attr__( 'Loading...', 'st-user' ); ?>" value="<?php echo esc_attr__( 'Update Profile','st-user' ); ?>">
                </p>
            </div>
        </form>
        <?php } ?>

        <?php do_action( 'st_user_profile_after_form_body' , $user, $is_edit ) ?>
    </div>
</div>
<?php } ?>