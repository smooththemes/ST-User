<?php

class ST_User_Frontend{

    function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this , 'js' ) );
        add_action( 'wp_enqueue_scripts', array( $this , 'css' ) );
    }

    function js(){
        wp_enqueue_script('jquery');
        wp_enqueue_script('json2');
        wp_enqueue_script('modernizr', ST_User::$url.'templates/js/modernizr.js',array('jquery'), '2.7.1',  true  );
        wp_enqueue_script('st-user', ST_User::$url.'templates/js/st-user.js',array('jquery'), '1.0',  true  );

        wp_localize_script( 'st-user', 'ST_User',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php' )
            )
        );
    }

    function css(){
        wp_register_style( 'st-user-css', ST_User::$url.'templates/css/style.css' );
        wp_enqueue_style( 'st-user-css' );
    }

}

new ST_User_Frontend;
