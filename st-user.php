<?php
/*
Plugin Name: ST User
Plugin URI: #
Description: Advance Ajax WordPress Login & Register Form
Author: Sa Truong
Version: 1.0
Author URI: #
*/

define('ST_USER_URL', trailingslashit( plugins_url('', __FILE__) ) );
define('ST_USER_PATH', trailingslashit(plugin_dir_path( __FILE__)));

final class ST_User{

    /**
     * @var string
     */
    public $version = '1.0';

    public static $url = ST_USER_URL ;
    public static $path  = ST_USER_PATH ;
    public static $_instance  ;

    public static function instance(){
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct(){
        $this->load_textdomain();
        $this->includes();
    }

    public  function includes(){

        include_once $this->path.'includes/functions.php';
        include_once $this->path.'includes/class-user.php';
        include_once $this->path.'includes/class-shortcodes.php';
        include_once $this->path.'includes/class-ajax.php';
        if( is_admin() ){
            include_once $this->path.'includes/class-admin.php';
        }else{
            include_once $this->path.'includes/class-frontend.php';
        }
    }

    function load_textdomain(){
        load_plugin_textdomain( 'st-user', false, $this->path . 'languages' );
    }

}

/**
 * Returns the main instance of BASE to prevent the need to use globals.
 *
 * @since  1.0
 */
function ST_User_init() {
    return ST_User::instance();
}

// Global for backwards compatibility.
$GLOBALS['ST_User'] = ST_User_init();