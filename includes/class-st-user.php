<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    ST_User
 * @subpackage ST_User/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    ST_User
 * @subpackage ST_User/includes
 * @author     SmoothThemes
 */
class ST_User {


	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $st_user    The string used to uniquely identify this plugin.
	 */
	protected $st_user;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

    /**
     *  The Settings of this plugins
     *
     *
     * @since 1.0.0
     */
    public  $settings;

	public function __construct() {

		$this->st_user = 'st-user';
		$this->version = '1.0.0';

        $this->settings();
		$this->load_dependencies();
        add_action( 'plugins_loaded', array( $this, 'set_locale'  ) );
		$this->define_admin_hooks();
		$this->define_public_hooks();

        add_action( 'set_current_user', 'csstricks_hide_admin_bar' );

        /*
        $rules = get_option( 'rewrite_rules' );
        if ( ! isset( $rules['^'.$this->settings['profile_rewrite'].'/([^/]*)/?'] ) ) {

        }
        */

        flush_rewrite_rules() ;

        $this->profile_rewrite();
        $this->profile_rewrite_tag();

        // disable admin toolbar
        if ( ! current_user_can( 'edit_posts' ) ) {
            show_admin_bar( false );
        }

        do_action( 'st_user_init', $this );

	}

    /**
     * Add rewrite rule
     * Example the link:  http://yoursite.com/user/admin
     */
    public function profile_rewrite() {
        $string =  'index.php?page_id='.intval( $this->settings['account_page'] ).'&st_user_name=$matches[1]';
        add_rewrite_rule( '^'.$this->settings['profile_rewrite'].'/([^/]*)/?', $string , 'top');
        //echo $string;
    }

    /**
     * Add Write tags
     *
     * @usage: $wp_query->query_vars['st_user_name']
     */
    public function profile_rewrite_tag() {
         add_rewrite_tag('%st_user_name%', '([^&]+)');
    }

    /**
     * Get user profile data
     *
     * @return bool|object|stdClass|WP_User
     */
    public function get_user_profile( ){
        global $wp_query;
        if ( isset ( $wp_query->query_vars['st_user_name'] ) &&  $wp_query->query_vars['st_user_name'] != '' ) {
            $user_data = get_user_by( 'login', $wp_query->query_vars['st_user_name'] );
            return ( $user_data && $user_data->data->ID > 0 ) ?  $user_data->data : false;
        } else {
            return is_user_logged_in() ? wp_get_current_user() : false;
        }
    }

    /**
     * Get user Profile link
     *
     * @see wp_get_current_user
     *
     * @param object $user
     * @return string
     */
    public function get_profile_link( $user = null ){
        if ( ! is_user_logged_in() ) {
            return wp_login_url();
        }
        if (  ! $user ) {
            $user = wp_get_current_user();
        }
        global $wp_rewrite;
        if ( $wp_rewrite->using_permalinks() ){
            return trailingslashit( site_url() ).$this->settings['profile_rewrite'].'/'.$user->user_login;
        } else {
            return add_query_arg( array( 'st_user_name' => $user->user_login ), $this->settings['url']  );
        }
    }

    /**
     * Get user edit link
     *
     * @see wp_get_current_user
     *
     * @param object $user
     * @return string
     */
    public function get_edit_profile_link( $user ){
        return add_query_arg( array( 'st_edit' => 1 ), $this->get_profile_link( $user )  );
    }

    /**
     * Check if is current user
     *
     * @see wp_get_current_user
     *
     * @param object $user
     * @param object $user2
     */
    public function is_current_user( $user, $user2 = false ){
        return ( $user &&  $user2 && $user->ID >0  && $user->ID ==  $user2->ID ) ? true : false;
    }


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - ST_User_i18n. Defines internationalization functionality.
	 * - ST_User_Admin. Defines all hooks for the admin area.
	 * - ST_User_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-st-user-admin.php';

        /**
         * Load Cores
         */
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions.php';
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-user-action.php';
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/nav-menu.php';
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-shortcodes.php';
        new ST_User_Shortcodes( $this );

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-st-user-public.php';

	}

    /**
     * Load the plugin text domain for translation.
     */
    function set_locale() {
        load_plugin_textdomain( $this->get_st_user() , false, ST_USER_PATH . 'languages/' );
    }

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new ST_User_Admin( $this->get_st_user(), $this->get_version() );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ) );
	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new ST_User_Public( $this );

		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_scripts' ) );
		add_action( 'wp_footer', array( $plugin_public, 'modal' ) );

        /**
         * Add filter widget text shortcode
         */
        add_filter( 'widget_text', 'do_shortcode' );
        /**
         * Set default plugin page url
         */
        add_filter( 'st_user_url',array( $this, 'page_url' ) );

        /**
         * Set default logout redirect to url
         */
        add_filter( 'st_user_logout_url', array( $this, 'logout_url'  ) );
        add_filter( 'logout_url', array( $this, 'logout_url' ), 15, 2 );

        /**
         * Redirect to url when user logged in
         */
        add_filter( 'st_user_logged_in_redirect_to', array( $this, 'logged_in_url' ) );
        add_filter( 'login_redirect', array( $this, 'logged_in_url' ) );

        /**
         * Login url
         */
        add_filter( 'st_user_login_url', array( $this, 'login_url' ) );

        // disable default login url

        if ( $this->get_setting('disable_default_login')  && !isset( $_GET['interim-login'] ) ) {
            if ( ! is_admin()  ) {
                add_filter( 'login_url', array( $this, 'login_url' ) );
            }elseif ( defined( 'DOING_AJAX' )  ) {
                add_filter( 'login_url', array( $this, 'login_url' ) );
            }
        }

        /**
         * Filter Register url
         */
        add_filter( 'register_url', array( $this, 'register_url' ) );

        /**
         * Lost pwd url
         */
        add_filter( 'st_user_lost_passoword_url', array( $this, 'lost_pwd_url' ) );
        add_filter( 'lostpassword_url', array( $this, 'lost_pwd_url' ) );


        add_action( 'wp_ajax_st_user_ajax', array( $this, 'ajax' ) );
        add_action( 'wp_ajax_nopriv_st_user_ajax', array( $this, 'ajax' ) );

	}

    /**
     * Setup plugin settings
     *
     * @since 1.0.0
     */
    private function settings( ) {

        $default = array(
            'account_page'          => '',
            'profile_rewrite'       => 'user',
            'disable_default_login' => '',
            'login_redirect_url'    => '',
            'logout_redirect_url'   => '',
            'show_term'             => '',
            'term_mgs'              => '',
            'view_other_profiles'        =>'any', // logged,
            'form_login_header'          => 0,
            'form_register_header'       => 0,
            'form_reset_header'          => 0,
            'form_change_pass_header'    => 0,
            'form_profile_header'        => 0,

            'login_header_title'         => '',
            'register_header_title'      => '',
            'reset_header_title'         => '',
            'change_pass_header_title'   => '',

            'upload_dir'                 =>  WP_CONTENT_DIR . '/uploads/st-users/',
            'upload_url'                 =>  WP_CONTENT_URL . '/uploads/st-users/'
        );

        $this->settings = (array) get_option( 'st_user_settings' );
        $this->settings = wp_parse_args( $this->settings,  $default );

        if ( $this->settings['login_header_title'] == '' ) {
            $this->settings['login_header_title'] =  __( 'Login', 'st-user' );
        }

        if ( $this->settings['register_header_title'] == '' ) {
            $this->settings['register_header_title'] =  __( 'Sign up', 'st-user' );
        }

        if ( $this->settings['reset_header_title'] == '' ) {
            $this->settings['reset_header_title'] =  __( 'Reset your password', 'st-user' );
        }

        if ( $this->settings['change_pass_header_title'] == '' ) {
            $this->settings['change_pass_header_title'] =  __( 'Change your password', 'st-user' );
        }


        /**
         * The url of St User page
         * Change it in admin setting
         */
        $page_url =  ( $this->settings['account_page'] ) ? get_permalink( $this->settings['account_page'] ) : site_url('/') ;

        $this->settings['url'] = $page_url;

        if ( $this->settings['logout_redirect_url'] == '' ) {
            $this->settings['logout_redirect_url'] = '';
        }

        if ( $this->settings['login_redirect_url'] != '' ) {
            $this->settings['login_redirect_url'] = $this->settings['url'];
        }

        $this->settings['lost_pwd_url'] = add_query_arg( array( 'st_action' => 'lost-pass' ), $page_url );
        $this->settings['register_url'] = add_query_arg( array( 'st_action' => 'register' ), $page_url );

        $this->settings['term_link'] = get_permalink( get_option( 'st_user_term_page' ) );

        $this->settings['theme'] = apply_filters('st_user_theme', 'smooth' ); ;

        /**
         * Hook to change settings if you want
         * @since 1.0.0
         */
        $this->settings = apply_filters('st_user_setup_settings', $this->settings, $this );
    }

    /**
     *  Get setting by key
     *
     * @param $key
     * @param bool $default
     * @return mixed
     */
    public function get_setting( $key , $default =  false ) {
        if ( isset( $this->settings[  $key ] ) ) {
            return  $this->settings[  $key ];
        } else {
            return $default;
        }
    }

    /**
     * Plugin page url
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function page_url( $url = '' ) {
        return $this->get_setting( 'url' );
    }

    /**
     * Plugin page url
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function register_url( $url = '' ) {
        return $this->get_setting( 'register_url' );
    }

    /**
     * Redirect logged out url
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function logout_url( $url = '', $redirect = '' ) {
        if (  $redirect == '' ){
            $_redirect =  $this->get_setting( 'logout_redirect_url' );

            if ( $_redirect == '' ) {
                if ( ! defined('DOING_AJAX')) {
                    $_redirect = get_permalink();
                } else {

                }
            }

            if ( $_redirect != '' ) {
                $args = array( 'action' => 'logout' );
                if ( ! empty( $_redirect ) ) {
                    $args['redirect_to'] = urlencode( $_redirect );
                }

                $logout_url = add_query_arg( $args, site_url( 'wp-login.php', 'login' ) );
                $logout_url = wp_nonce_url( $logout_url, 'log-out' );
                return $logout_url;
            }

        }
        return $url;
    }

    /**
     * Redirect Logged in out url
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function logged_in_url( $url = '' ) {
         if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {
            return $url;
         }
        return ( $this->get_setting( 'login_redirect_url' ) != '' ) ? $this->get_setting( 'login_redirect_url' ) : $url ;
    }

    /**
     * Set Plugin url it can be login/profile/register page
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function login_url( $url = '' ) {
        return $this->get_setting( 'url' );
    }

    /**
     * Set lost password url
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function lost_pwd_url( $url = '' ) {
        return $this->get_setting( 'lost_pwd_url' );
    }


    /**
     * Set term and condition link
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function term_link( $url = '' ) {
        return $this->get_setting( 'term_link' );
    }


	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_st_user() {
		return $this->st_user;
	}


	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


    /**
     * Get Template path
     *
     * Override template in your theme
     * YOUR_THEME_DIR/templates/{$template}
     * or YOUR_THEME_DIR/templates/st-user/{$template}
     * or YOUR_THEME_DIR/st-user/{$template}
     *
     * @since 1.0
     * @param string $template
     * @return string
     */
    public function get_file_template( $template ='' ) {
        /**
         * Overridden template in your theme
         * YOUR_THEME_DIR/templates/{$template}
         * or YOUR_THEME_DIR/templates/st-user/{$template}
         * or YOUR_THEME_DIR/st-user/{$template}
         */
        $templates =  array(
            'templates/'.$template,
            'templates/st-user/'.$template,
            'st-user/'.$template,
        );

        if ( $overridden_template = locate_template( $templates ) ) {
            // locate_template() returns path to file
            // if either the child theme or the parent theme have overridden the template
            return $overridden_template;
        } else {
            // If neither the child nor parent theme have overridden the template,
            // we load the template from the 'templates' directory if this plugin
            return ST_USER_PATH . 'templates/'.$template;
        }
    }


    /**
     * Get content form a file.
     *
     * @since 1.0
     * @param string $template full file path
     * @param array $custom_data
     * @return string
     */
    public function get_file_content( $template, $custom_data = array() ) {
        ob_start();
        $old_content = ob_get_clean();
        ob_start();
        do_action( 'st_user_before_content_load', $template , $custom_data );
        if ( is_file( $template ) ) {
            if ( is_array( $custom_data ) ) {
                extract( $custom_data);
            }
            //load_template();
            require $template  ;
        }
        do_action( 'st_user_after_content_load', $template , $custom_data );
        $content = ob_get_clean();
        echo $old_content;
        return $content;
    }

    /**
     * Get template content
     * @see
     * @see get_file_content
     * @see get_file_template
     * @param $template
     * @param array $custom_data
     * @return string
     */
    public  function get_template_content( $template,  $custom_data = array() ) {
        return  $this->get_file_content( $this->get_file_template( $template ) , $custom_data );
    }

    /**
     * Get user media
     *
     * @param string $media_type
     * @param string $type url|path
     * @return bool|string
     */
    public static function get_user_media( $media_type = 'avatar', $type = 'url' ,  $user  = false ){

        if ( ! $user ) {
            $user =  wp_get_current_user();
        }
        $media  = get_user_meta( $user->ID, 'st-user-'.$media_type , true );
        if ( ! $media ) {
            return false;
        }

        $path = ST_User()->settings['upload_dir'].$media;
        if ( file_exists( $path ) ) {
            if ( strtolower( $type ) !== 'path' ) {
                return  ST_User()->settings['upload_url'].$media;
            } else {
                return $path;
            }
        }

        return false;

    }

    /**
     * Ajax Handle
     * @since 1.0.0
     */
    public function  ajax( ) {
        $act = $_REQUEST['act'];
        switch ( $act ) {
            case 'login-template':
                echo $this->get_template_content( 'login.php' );
                break;
            case 'register-template':
                echo $this->get_template_content( 'register.php' ) ;
                break;
            case 'lostpwd-template':
                echo $this->get_template_content( 'lost-password.php' ) ;
                break;
            case 'reset-template':
                echo $this->get_template_content( 'reset.php' ) ;
                break;
            case 'change-pwd-template':
                echo $this->get_template_content( 'change-password.php' ) ;
                break;
            case 'profile-template':
                if ( ! is_user_logged_in() ) {
                    echo $this->get_template_content( 'login.php' );
                } else {
                    echo $this->get_template_content( 'profile.php' ) ;
                }
                break;
            case 'modal-template':
                echo $this->get_template_content( 'modal.php' ) ;
                break;
            case 'do_login':
                echo ST_User_Action::do_login();
                break;
            case 'do_register':
                echo ST_User_Action::do_register();
                break;
            case 'retrieve_password':
                echo ST_User_Action::retrieve_password();
                break;
            case 'do_reset_pass':
                echo ST_User_Action::reset_pass();
                break;
            case 'do_update_profile':
                echo ST_User_Action::update_profile();
                break;
            case 'update_cover':
                echo ST_User_Action::media_upload( 'cover' );
                break;
            case 'update_avatar':
                // echo ST_User_Action::media_upload( 'cover' );
                echo ST_User_Action::media_upload( 'avatar' );
                break;

            case 'crop_cover':
                // echo ST_User_Action::media_upload( 'cover' );
                echo ST_User_Action::crop_media( 'cover' );
                break;
            case 'crop_avatar':
                // echo ST_User_Action::media_upload( 'cover' );
                echo ST_User_Action::crop_media( 'avatar' );
                break;

            case 'remove_media':
                // echo ST_User_Action::media_upload( 'cover' );
                ST_User_Action::remove_media( $_REQUEST['media_type'] );
                break;

        }
        exit();
    }

}
