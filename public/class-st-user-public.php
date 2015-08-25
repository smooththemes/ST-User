<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://smooththemes.com
 * @since      1.0.0
 *
 * @package    ST_User
 * @subpackage ST_User/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    ST_User
 * @subpackage ST_User/public
 * @author     SmoothThemes
 */
class ST_User_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $st_user    The ID of this plugin.
	 */
	private $st_user;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $st_user       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */

    /**
     * Instance classs ST_User
     * @since 1.0
     * @var ST_User
     */
    private  $instance;

    /**
     * Current action of plugin
     * @since 1.0.0
     */
    private  $current_action;

	public function __construct( $instance ) {

        $this->instance = $instance;
        $this->current_action = isset( $_REQUEST['st_action'] ) ? sanitize_key( $_REQUEST['st_action'] ) : '';

		$this->st_user = $this->instance->get_st_user();
		$this->version = $this->instance->get_version();

        add_action( 'st_user_profile_header', array( $this, 'profile_header' ) );
        add_action( 'st_user_profile_before_form_body', array( $this, 'profile_sidebar' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ST_User_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ST_User_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


        wp_register_style( $this->st_user, ST_USER_URL.'public/partials/'.$this->instance->settings['theme'].'/css/style.css' );
        wp_enqueue_style( $this->st_user );

        if ( is_user_logged_in() ) {
            wp_enqueue_style( 'dashicons' );
            wp_enqueue_style( 'croppic' , ST_USER_URL.'croppic/croppic.css'  );
        }
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ST_User_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ST_User_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'json2' );

        if ( is_user_logged_in() ) {
            wp_enqueue_script( 'croppic' , ST_USER_URL.'croppic/croppic.js', array('jquery'), false, true  );
        }

        // wp_enqueue_script( 'modernizr', ST_USER_URL.'public/js/modernizr.js', array('jquery'), '2.7.1', true  );
        wp_enqueue_script( $this->st_user , ST_USER_URL.'public/partials/'.$this->instance->settings['theme'].'/js/user.js', array('jquery'), '1.0', true  );

        wp_localize_script( $this->st_user , 'ST_User',
            apply_filters('st_user_localize_script', array(
                'ajax_url'          => admin_url( 'admin-ajax.php' ),
                'current_action'    => $this->current_action,
                'hide_txt'          => __('Hide','st-user'),
                'show_txt'          => __('Show','st-user'),
                'current_url'       => $_SERVER['REQUEST_URI'],
                '_wpnonce'          => wp_create_nonce(),
                'cover_text'        => __('Cover image','st-user'),
                'avatar_text'       => __('Avatar','st-user'),
                'remove_text'       => __('Remove','st-user'),
                'upload_text'       => __('Upload Photo','st-user'),
            ) )
        );

    }

    /**
     *  Display modal
     * @since 1.0
     */
    function modal() {
        echo $this->instance->get_template_content( 'modal.php', array('current_action' => $this->current_action ) ) ;
    }

    /**
     * Display profile header
     * @param $user
     */
    public static function profile_header( $user ){

        $image_url = ST_User()->get_user_media('cover');
        $edited_image_url = ST_User()->get_user_media('cover-img');
        if ( !$edited_image_url ) {
            $edited_image_url = $image_url;
        }


        $avatar_url = ST_User()->get_user_media('avatar');
        $edited_avatar_url = ST_User()->get_user_media('avatar-img');
        if ( !$edited_avatar_url ) {
            $edited_avatar_url = $avatar_url;
        }

        $is_edit = ( isset( $_REQUEST['st_edit'] ) ) ?  true : false;
        ?>
        <div id="st-profile-cover" data-change="<?php echo $is_edit ? 'true' : 'false'; ?>" class="st-profile-cover coppic" style="background-image: url('<?php echo esc_attr( $edited_image_url ); ?>');" data-cover="<?php echo ( $image_url ) ? $image_url : '';  ?>"></div>

        <div class="st-profile-meta clear-fix">
            <div data-change="<?php echo $is_edit ? 'true' : 'false'; ?>" style="background-image: url('<?php echo esc_attr( $edited_avatar_url ); ?>');" data-cover="<?php echo ( $edited_avatar_url ) ? $edited_avatar_url : '';  ?>" class="st-profile-avatar coppic"></div>

            <div class="st-profile-meta-info">
                <span class="st-display-name"><?php echo esc_html( $user->display_name ); ?></span>

                    <span class="user-join-date"><?php
                        printf( __( 'Joined %s', 'st-user' ),  date_i18n( get_option('date_format'), strtotime( $user->user_registered ) ) );
                        ?>
                    </span>
            </div>

            <div class="st-user-socials">
                <a href="<?php echo esc_attr( get_user_meta( $user->ID, 'facebook', true ) ); ?>"><span class="dashicons dashicons-facebook-alt"></span></a>
                <a href="<?php echo esc_attr( get_user_meta( $user->ID, 'twitter', true ) ); ?>"><span class="dashicons dashicons-twitter"></span></a>
                <a href="<?php echo esc_attr( get_user_meta( $user->ID, 'google', true ) ); ?>"><span class="dashicons dashicons-googleplus"></span></a>
            </div>
            <?php do_action('st_user_profile_meta'); ?>

        </div>
        <?php
    }

    /**
     * Display profile sidebar
     * @param $user
     */
    public static function profile_sidebar( $user ){
        ?>
        <ul class="st-form-sidebar">
            <li><a class="st-profile-link" href="<?php echo  apply_filters( 'st_user_url', '#' ) ; ?>"><?php _e( 'Public profile', 'st-user' ); ?></a></li>
            <li><a class="st-edit-link" href="<?php echo add_query_arg( array( 'st_edit' => 1 ) , apply_filters( 'st_user_url', '#' )  ); ?>"><?php _e( 'Edit profile', 'st-user' ); ?></a></li>
        </ul>
        <?php
    }



}
