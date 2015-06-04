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
 * @author     Truong Sa <shrimp2t@gmail.com>
 */
class ST_User {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      ST_User_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

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
    protected  $settings;

	public function __construct() {

		$this->st_user = 'st-user';
		$this->version = '1.0.0';

        $this->settings();
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

        add_action('set_current_user', 'csstricks_hide_admin_bar');

        // disable admin toolbar
        if (!current_user_can('edit_posts')) {
            show_admin_bar(false);
        }


	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - ST_User_Loader. Orchestrates the hooks of the plugin.
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
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-st-user-loader.php';
        $this->loader = new ST_User_Loader();

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-st-user-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-st-user-admin.php';

        /**
         * Load Cores
         */
        include_once plugin_dir_path( dirname( __FILE__ ) ).'includes/functions.php';
        include_once plugin_dir_path( dirname( __FILE__ ) ).'includes/class-user-action.php';
        include_once plugin_dir_path( dirname( __FILE__ ) ).'includes/class-shortcodes.php';
        new ST_User_Shortcodes( $this );

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-st-user-public.php';

        include_once plugin_dir_path( dirname( __FILE__ ) ).'includes/class-ajax.php';

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the ST_User_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new ST_User_i18n();
		$plugin_i18n->set_domain( $this->get_st_user() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

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

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

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

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'modal' );

        /**
         * Add filter widget text shortcode
         */
        add_filter('widget_text', 'do_shortcode');
        /**
         * Set default plugin page url
         */
        $this->loader->add_filter('st_user_url', $this, 'page_url');

        /**
         * Set default logout redirect to url
         */
        $this->loader->add_filter('st_user_logout_url', $this, 'logout_url');
        $this->loader->add_filter('logout_redirect', $this, 'logout_url');

        /**
         * Redirect to url when user logged in
         */
        $this->loader->add_filter('st_user_logged_in_redirect_to', $this, 'logged_in_url');

        /**
         * Login url
         */
        $this->loader->add_filter('st_user_login_url', $this, 'login_url');
        $this->loader->add_filter('st_user_lost_passoword_url', $this, 'lost_pwd_url');

        $ajax = new ST_User_Ajax( $this );

        $this->loader->add_action( 'wp_ajax_st_user_ajax', $ajax,  'ajax'  );
        $this->loader->add_action( 'wp_ajax_nopriv_st_user_ajax', $ajax, 'ajax' );

	}

    /**
     * Setup plugin settings
     *
     * @since 1.0.0
     */
    private function settings( ){
        $this->settings = array();
        $user_page_id  = 19;
        $user_page_url = get_permalink( $user_page_id );
        /**
         * The url of St User page
         * Change it in admin setting
         */
        $this->settings['url'] = $user_page_url;
        $this->settings['logout_url'] = $user_page_url;
        $this->settings['logged_in_url'] = $user_page_url;
        $this->settings['lost_pwd_url'] = $user_page_url;
    }

    /**
     *  Get setting by key
     *
     * @param $key
     * @param bool $default
     * @return mixed
     */
    public function get_setting( $key , $default =  false ){
        if( isset(  $this->settings[  $key ] ) ){
            return  $this->settings[  $key ];
        }else{
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
    public function page_url(  $url = '' ){
        return $this->get_setting('url');
    }

    /**
     * Redirect logged out url
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function logout_url(  $url = '' ){
       return $this->get_setting('logout_url');
    }

    /**
     * Redirect Logged in out url
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function logged_in_url(  $url = '' ){
        return $this->get_setting('logged_in_url');
    }

    /**
     * Set Plugin url it can be login/profile/register page
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function login_url(  $url = '' ){
        return $this->get_setting('url');
    }

    /**
     * Set lost password url
     *
     * @since 1.0.0
     * @param string $url
     * @return mixed
     */
    public function lost_pwd_url(  $url = '' ){
        return $this->get_setting('lost_pwd_url');
    }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
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
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    ST_User_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
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
    public function get_file_template( $template ='' ){
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
            return ST_USER_PATH . 'public/partials/'.$template;
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
    public function get_file_content( $template, $custom_data = array() ){
        ob_start();
        $old_content = ob_get_clean();
        ob_start();
        if( is_file( $template ) ){
            if ( is_array( $custom_data ) ){
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
    public  function get_template_content( $template,   $custom_data = array() ){
        return  $this->get_file_content( $this->get_file_template(  $template ) , $custom_data );
    }

    public function get_user(  $user_id = 0 ){
        wp_get_current_user();
    }
}
