<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    ST_User
 * @subpackage ST_User/admin/partials
 */


$default = array(
    'account_page'          => '',
    'disable_default_login' => '',
    'login_redirect_url'    => '',
    'logout_redirect_url'   => '',
    'show_term'             => '',
    'term_mgs'             => '',
    'form_login_header'          => 0,
    'form_register_header'       => 0,
    'form_reset_header'          => 0,
    'form_change_pass_header'    => 0,
    'form_profile_header'        => 0,
);

if ( isset( $_POST['submit'] ) ) {
    $values = $_POST[ 'st_user_settings' ] ;
    $values['term_mgs'] = trim( stripslashes( $_POST['st_user_settings_mgs'] ) );
    update_option( 'st_user_settings', $values );

}

$settings = (array) get_option( 'st_user_settings' );
$settings = wp_parse_args( $settings,  $default );

?>
<h2><?php _e( 'ST User Settings','st-user' ); ?></h2>
<?php if ( isset( $_POST['submit'] ) ) { ?>
    <div class="updated notice notice-success is-dismissible below-h2" id="message">
        <p><?php _e( 'Your settings updated.' , 'st-user' ); ?></p>
    </div>
<?php } ?>

<form novalidate="novalidate" action="" method="post">
    <h3><?php _e( 'General', 'st-user' ); ?></h3>

    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><label for="st_user_account_page"><?php _e( 'Account page', 'st-user' ); ?></label></th>
            <td>
                <?php
                wp_dropdown_pages (
                    array(
                    //'depth'                 => 0,
                    //'child_of'              => 0,
                    'selected'              => $settings['account_page'],
                    //'echo'                  => 1,
                    'name'                  => 'st_user_settings[account_page]',
                    'id'                    => null, // string
                    'show_option_none'      =>  __( 'Select a page', 'st-user' ), // string
                    'show_option_no_change' => null, // string
                    'option_none_value'     => null, // string
                ) );
                ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><?php _e ( 'Login','st-user' ); ?></th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span><?php _e( 'Login', 'st-user' ); ?></span></legend>
                    <label >
                        <input type="checkbox" <?php checked ( $settings['disable_default_login'] , 1 ) ?> value="1"  name="st_user_settings[disable_default_login]">
                        <?php _e( 'User Account page as login page.', 'st-user' ); ?>
                    </label>
                    <p class="description"><?php _e( 'Default login page of WordPress will disable.', 'st-user' ); ?></p>
                </fieldset>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="st_user_login_redirect_url"><?php _e('Login Redirect (URL)', 'st-user'); ?></label></th>
            <td>
                <input type="text" class="regular-text" value="<?php echo esc_attr( $settings['login_redirect_url'] ); ?>" id="st_user_login_redirect_url" name="st_user_settings[login_redirect_url]">
                <p class="description"><?php _e( 'The url will redirect when you logged in, leave empty to redirect home page.', 'st-user' ); ?></p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="st_user_logout_redirect_url"><?php _e( 'Logout Redirect (URL)', 'st-user' ); ?></label></th>
            <td>
                <input type="text" class="regular-text" value="<?php echo esc_attr( $settings['logout_redirect_url'] ); ?>" id="st_user_logout_redirect_url" name="st_user_settings[logout_redirect_url]">
                <p class="description"><?php _e( 'The url will redirect when you logout, leave empty to redirect home page.', 'st-user' ); ?></p>
            </td>
        </tr>


        <tr>
            <th scope="row"><label for="st_user_term_page"><?php _e('Terms and Conditions','st-user'); ?></label></th>
            <td>
                <label >
                    <input type="checkbox" <?php checked ( $settings['show_term'] , 1 ) ?> value="1"  name="st_user_settings[show_term]">
                    <?php _e( 'Enable "Terms and Conditions" to sign up form.', 'st-user' ); ?>
                </label>
                <br/>
                <br/>
                <label ><strong><?php _e( 'Terms and Conditions Message ', 'st-user' ); ?></strong></label>
                <?php
                wp_editor( $settings['term_mgs'] , 'st_user_settings_mgs', array(
                    'textarea_rows' => 6
                )  );
                ?>

            </td>
        </tr>

        <tr>
            <th scope="row"><?php _e ( 'Form Settings','st-user' ); ?></th>
            <td>
                <fieldset>
                    <label >
                        <input type="checkbox" <?php checked ( $settings['form_login_header'] , 1 ) ?> value="1"  name="st_user_settings[form_login_header]">
                        <?php _e( 'Show Login form header', 'st-user' ); ?>
                    </label><br>
                    <label >
                        <input type="checkbox" <?php checked ( $settings['form_register_header'] , 1 ) ?> value="1"  name="st_user_settings[form_register_header]">
                        <?php _e( 'Show Register form header', 'st-user' ); ?>
                    </label><br>
                    <label >
                        <input type="checkbox" <?php checked ( $settings['form_reset_header'] , 1 ) ?> value="1"  name="st_user_settings[form_reset_header]">
                        <?php _e( 'Show reset form header', 'st-user' ); ?>
                    </label><br>
                    <label >
                        <input type="checkbox" <?php checked ( $settings['form_change_pass_header'], 1 ) ?> value="1"  name="st_user_settings[form_change_pass_header]">
                        <?php _e( 'Show change password form header', 'st-user' ); ?>
                    </label><br>
                    <label >
                        <input type="checkbox" <?php checked ( $settings['form_profile_header'] , 1 ) ?> value="1"  name="st_user_settings[form_profile_header]">
                        <?php _e( 'Show profile form header', 'st-user' ); ?>
                    </label><br>

                </fieldset>
            </td>
        </tr>

        <?php
        /**
         * hook you can add more fields if you want
         * @since 1.0.0
         */
        do_action( 'st_user_settings_fields' );
        ?>
        </tbody>
    </table>

    <?php
    /**
     * hook you can add more table fields if you want
     * @since 1.0.0
     */
    do_action( 'st_user_settings_table' );
    ?>

    <p class="submit">
        <input type="submit" value="<?php echo esc_attr__( 'Save Changes', 'st-user' ); ?>" class="button button-primary" id="submit" name="submit">
    </p>
</form>

