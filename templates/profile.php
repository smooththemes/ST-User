<?php
/**
 * The Template for displaying Profile form
 *
 * Override template in your theme by copying it to:
 * YOUR_THEME_DIR/templates/profile.php
 * or YOUR_THEME_DIR/templates/st-user/profile.php
 * or YOUR_THEME_DIR/st-user/profile.php
 *
 * @package 	ST-User/Templates
 * @version     1.0
 */


$user = ST_User()->get_user_profile();

if ( ! $user ) {
    ?>
    <div class="st-user-not-found">
        <h2><?php _e( 'Nothing found', 'st-user' ); ?></h2>
    </div>
    <?php
} else {


$current_user = wp_get_current_user();

$is_edit = ( $current_user && $user && $current_user->ID == $user->ID && isset( $_REQUEST['st_edit'] ) ) ?  true : false;
?>
<div class="st-profile-wrapper stuser-form-profile" >

    <div class="stuser-form-header">
        <?php do_action( 'st_user_profile_header' , $user, $current_user , $is_edit );  ?>
    </div>

    <div class="stuser-form-body clear-fix">

        <?php
        do_action( 'st_user_profile_before_form_body', $user, $current_user , $is_edit );
        ?>
        <?php if ( !$is_edit ) {

            ?>
        <div class="stuser-form-profile clear-fix"  >

            <div class="stuser-form-fields viewing-info">
                <p class="fieldset stuser_input st-username">
                    <label class=""><?php _e( 'User Name:', 'st-user' ); ?></label>
                    <span>
                        <?php echo esc_html( $user->user_login ); ?>
                    </span>
                </p>
                <?php if ( ST_User()->is_current_user( $user, $current_user ) ){ ?>
                <p class="fieldset stuser_input st-email">
                    <label class=""><?php _e( 'E-mail:', 'st-user' ); ?></label>
                    <span>
                        <?php echo esc_html( $user->user_email ); ?>
                    </span>
                </p>
                <?php } ?>

                <?php if (  get_user_meta( $user->ID, 'first_name', true ) != '' ){ ?>
                <p class="fieldset stuser_input st-firstname">
                    <label class=""><?php _e( 'First Name:', 'st-user' ); ?></label>
                    <span class="">
                        <?php
                        echo esc_html( get_user_meta( $user->ID, 'first_name', true ) ); ?>
                    </span>
                </p>
                <?php } ?>

                <?php if (  get_user_meta( $user->ID, 'last_name', true ) != '' ){ ?>
                <p class="fieldset stuser_input st-lastname">
                    <label class=""><?php _e( 'Last Name:', 'st-user' ); ?></label>
                    <span class="">
                        <?php echo  esc_html( get_user_meta( $user->ID, 'last_name', true ) ); ?>
                    </span>
                </p>
                <?php } ?>

                <?php if (  $user->display_name!= '' ){ ?>
                <p class="fieldset stuser_input">
                    <label class=""><?php _e( 'Display Name:', 'st-user' ); ?></label>
                    <span><?php  echo esc_html( $user->display_name );  ?></span>
                </p>
                <?php } ?>

                <?php if ( $user->user_url  != '' ){ ?>
                <p class="fieldset stuser_input st-website">
                    <label class="" for="signin-password"><?php _e( 'Website:', 'st-user' ); ?></label>
                    <span class="">
                        <?php echo esc_html( $user->user_url ); ?>
                    </span>
                </p>
                <?php } ?>
                <?php if (  get_user_meta( $user->ID, 'description', true ) != '' ){ ?>
                <p class="fieldset stuser_input">
                    <label class=""><?php _e( 'Bio:', 'st-user' ); ?></label>
                    <span>
                        <?php echo  esc_html( get_user_meta( $user->ID, 'description', true ) ); ?>
                    </span>
                </p>
                <?php } ?>

            </div>
        </div>

        <?php  } else {  ?>

        <form class="stuser-form-profile stuser-form" action="<?php echo site_url('/'); ?>" method="post" >
            <p class="st-user-msg <?php echo isset( $_REQUEST['st_profile_updated'] ) &&  $_REQUEST['st_profile_updated']  == 1 ? 'st-show' : ''; ?>"><?php _e( 'Your profile updated.', 'st-user' ); ?></p>
            <p class="st-user-msg st-errors-msg"></p>

            <div class="stuser-form-fields">
                <p class="fieldset stuser_input st-username">
                    <label><?php _e( 'User Name', 'st-user' ); ?></label>
                    <input value="<?php echo esc_attr( $user->user_login ); ?>" readonly="readonly" class="input full-width has-padding has-border" type="text"  placeholder="<?php echo esc_attr__( 'Your username', 'st-user' ) ; ?>">
                </p>

                <p class="fieldset stuser_input st-email">
                    <label><?php _e( 'E-mail', 'st-user' ); ?></label>
                    <input name="st_user_data[user_email]" value="<?php echo esc_attr( $user->user_email ); ?>" class="full-width has-padding has-border" type="email" placeholder="<?php echo esc_attr__( 'E-mail', 'st-user' ); ?>">
                    <span class="st-error-message"></span>
                </p>

                <p class="fieldset stuser_input st-firstname">
                    <label><?php _e( 'First Name', 'st-user' ); ?></label>
                    <input name="st_user_data[first_name]" value="<?php echo esc_attr( get_user_meta( $user->ID, 'first_name', true ) ); ?>" class="input full-width has-padding has-border" type="text"  placeholder="<?php echo esc_attr__( 'First name', 'st-user' ) ; ?>">
                </p>

                <p class="fieldset stuser_input st-lastname">
                    <label><?php _e( 'Last Name', 'st-user' ); ?></label>
                    <input name="st_user_data[last_name]" value="<?php echo esc_attr( get_user_meta( $user->ID, 'last_name', true ) ); ?>" class="input full-width has-padding has-border"  type="text"  placeholder="<?php echo esc_attr__('Last name','st-user') ; ?>">
                </p>

                <p class="fieldset stuser_input st-input-display-name">
                    <label><?php _e( 'Display Name', 'st-user' ); ?></label>
                    <input name="st_user_data[display_name]" value="<?php echo esc_attr( $user->display_name ); ?>" class="input full-width has-padding has-border"  type="text"  placeholder="<?php echo esc_attr__( 'Display name','st-user' ) ; ?>">
                </p>

                <p class="fieldset stuser_input st-website">
                    <label><?php _e( 'Website', 'st-user' ); ?></label>
                    <input name="st_user_data[user_url]" value="<?php echo esc_attr( $user->user_url ); ?>" class="input full-width has-padding has-border"  type="text"  placeholder="<?php echo esc_attr__( 'Website', 'st-user' ) ; ?>">
                </p>

                <p class="fieldset stuser_input st-pwd pass1">
                    <label><?php _e( 'New Password', 'st-user' ); ?></label>
                    <input name="st_user_data[user_pass]" autocomplete="off" class="input full-width has-padding has-border" type="password"  placeholder="<?php echo esc_attr__( 'New Password', 'st-user' ) ; ?>">
                    <a href="#0" class="hide-password"><?php _e('Show','st-user') ?></a>
                    <span class="st-error-message"></span>
                </p>
                <p class="fieldset stuser_input st-pwd pass2">
                    <label><?php _e( 'Comfirm New Password', 'st-user' ); ?></label>
                    <input name="st_user_pwd2" autocomplete="off" class="input full-width has-padding has-border" type="password"  placeholder="<?php echo esc_attr__( 'Confirm New Password','st-user' ) ; ?>">
                    <a href="#0" class="hide-password"><?php _e( 'Show', 'st-user' ) ?></a>
                    <span class="st-error-message"></span>
                </p>
                <p class="fieldset stuser_input st-website">
                    <label><?php _e( 'Bio', 'st-user' ); ?></label>
                    <textarea class="full-width" name="st_user_data[description]"><?php echo esc_attr( get_user_meta( $user->ID, 'description', true ) ); ?></textarea>
                </p>
                <p class="fieldset stuser_input st-firstname">
                    <label><?php _e( 'Facebook URL', 'st-user' ); ?></label>
                    <input name="st_user_data[facebook]" value="<?php echo esc_attr( get_user_meta( $user->ID, 'facebook', true ) ); ?>" class="input full-width has-padding has-border" type="text"  placeholder="<?php echo esc_attr__( 'Facebook URL', 'st-user' ) ; ?>">
                </p>
                <p class="fieldset stuser_input st-firstname">
                    <label><?php _e( 'Twitter URL', 'st-user' ); ?></label>
                    <input name="st_user_data[twitter]" value="<?php echo esc_attr( get_user_meta( $user->ID, 'twitter', true ) ); ?>" class="input full-width has-padding has-border" type="text"  placeholder="<?php echo esc_attr__( 'Twitter URL', 'st-user' ) ; ?>">
                </p>
                <p class="fieldset stuser_input st-firstname">
                    <label ><?php _e( 'Google+ URL', 'st-user' ); ?></label>
                    <input name="st_user_data[google]" value="<?php echo esc_attr( get_user_meta( $user->ID, 'google', true ) ); ?>" class="input full-width has-padding has-border" type="text"  placeholder="<?php echo esc_attr__( 'Google+ URL', 'st-user' ) ; ?>">
                </p>
                <?php

                /**
                 * Hook to add more setting for profile if want
                 */
                do_action( 'st_user_profile_more_fields', $user, $current_user, $is_edit );
                ?>
                <p class="fieldset">
                    <input class="<?php echo esc_attr( apply_filters( 'st_user_form_submit_btn_class', 'profile-submit button btn' ) ); ?>" type="submit" data-loading-text="<?php echo esc_attr__( 'Loading...', 'st-user' ); ?>" value="<?php echo esc_attr__( 'Update Profile','st-user' ); ?>">
                </p>
            </div>
        </form>
        <?php } ?>

        <?php do_action( 'st_user_profile_after_form_body' , $user, $current_user, $is_edit ) ?>
    </div>
</div>

<?php

}