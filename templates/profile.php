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
    $action = isset( $_REQUEST['st_action'] ) ? strtolower( $_REQUEST['st_action'] ) : '';

    ?>
    <div class="st-profile-wrapper stuser-form-profile" >

        <div class="stuser-form-header">
            <?php do_action( 'st_user_profile_header' , $user, $current_user , $action );  ?>
        </div>

        <div class="stuser-form-body clear-fix">
            <?php
            do_action( 'st_user_profile_before_form_body', $user, $current_user , $action );
            do_action('st_user_profile_form_body', $user, $current_user , $action );
            do_action( 'st_user_profile_after_form_body' , $user, $current_user, $action );
            ?>
        </div>
    </div>

    <?php

}