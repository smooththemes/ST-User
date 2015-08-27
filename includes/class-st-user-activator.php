<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    ST_User
 * @subpackage ST_User/includes
 * @author     SmoothThemes
 */
class ST_User_Activator {

	/**
	 * Run settings when plugin active
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        $account_slug   = 'account';
        $shortcode_base = 'st_user';
        $page = array(
            'post_title'   => __('Account','st-user'),
            'post_name'    => $account_slug,
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => '['.$shortcode_base.']',

        );
        $page_id = 0;
        $p = get_page_by_path( $account_slug, OBJECT, 'page' );
        if ( $p ) {
            $page_id = $p->ID;

            if ( strpos( $p->post_content, "[{$shortcode_base}]" ) === false ) {
                $p->post_content = '['.$shortcode_base.']'."\r\n \r\n". $p->post_content;
                wp_update_post( $p );
            }

        } else {
            $r = wp_insert_post( $page );
            if ( ! is_wp_error( $r ) && is_numeric( $r ) ) {
                $page_id = $r;
            }
        }

        $default = array(
            'account_page'          => $page_id,
            'disable_default_login' => '',
            'login_redirect_url'    => '',
            'logout_redirect_url'   => '',
            'show_term'             => '',
            'term_mgs'              => '',
            'view_other_profiles'        =>'any', // logged,
            'form_login_header'          => 0,
            'form_register_header'       => 0,
            'form_reset_header'          => 1,
            'form_change_pass_header'    => 0,
            'form_profile_header'        => 1,
        );

        update_option( 'st_user_settings', $default );
	}

}
