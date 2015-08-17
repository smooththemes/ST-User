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

        // disable admin toolbar
        if ( ! current_user_can( 'edit_posts' ) ) {
            show_admin_bar( false );
        }

        do_action( 'st_user_init', $this );

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

        /**
         * Change  term condition link
         */
        add_filter( 'st_user_term_link', array( $this, 'term_link' ) );

        add_action( 'wp_ajax_st_user_ajax', array( $this, 'ajax' ) );
        add_action( 'wp_ajax_nopriv_st_user_ajax', array( $this, 'ajax' ) );

	}

    /**
     * Setup plugin settings
     *
     * @since 1.0.0
     */
    private function settings( ) {
        $this->settings = array();

        /**
         * The url of St User page
         * Change it in admin setting
         */
        $page_id = get_option( 'st_user_account_page' );
        $page_url =  get_permalink( $page_id );
        $this->settings['url'] = ($page_id) ?  $page_url :  site_url('/');

        $this->settings['disable_default_login'] = get_option( 'st_user_disable_default_login' );

        $this->settings['logout_url'] =  get_option( 'st_user_logout_redirect_url' );
        if ( $this->settings['logout_url'] == '' ) {
            $this->settings['logout_url'] = $this->settings['url'];
        }

        if ( ! ( $this->settings['logged_in_url'] = get_option( 'st_user_login_redirect_url' ) ) ) {
            $this->settings['logged_in_url'] = $this->settings['url'];
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
        return $this->get_setting('url');
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
            $_redirect =  $this->get_setting( 'logout_url' );

            if ( $_redirect == '' ) {
                if ( ! defined('DOING_AJAX')) {
                    $_redirect = get_permalink();
                } else {

                }
            }

            if ( $_redirect != '' ) {
                $args = array('action' => 'logout');
                if ( ! empty( $_redirect ) ) {
                    $args['redirect_to'] = urlencode( $_redirect );
                }

                $logout_url = add_query_arg($args, site_url('wp-login.php', 'login'));
                $logout_url = wp_nonce_url($logout_url, 'log-out');
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
        return ( $this->get_setting( 'logged_in_url' ) != '' ) ? $this->get_setting( 'logged_in_url' ) : $url ;
    }

    /**
     * Set Plugin url it can be login/profile/register page
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function login_url( $url = '' ) {
        return $this->get_setting('url');
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
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

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
            return ST_USER_PATH . 'public/partials/'.$this->settings['theme'].'/'.$template;
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
        if ( is_file( $template ) ) {
            if ( is_array( $custom_data ) ) {
                extract( $custom_data);
            }
            //load_template();
            require $template  ;
        }
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
        }
        exit();
    }

}
