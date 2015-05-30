<?php
class ST_User_Shortcodes{

    function __construct(){

    }

    function login( $atts, $content = "" ){
        $atts = shortcode_atts(array(
            'ajax_load' => 'true' ,
            'redirect' => '', // page id or url
        ), $atts );
        $atts['action'] = 'login-template';
        extract(  $atts );
        $content ='';
        if(  st_is_true ( $atts['ajax_load'] ) ){
             // leave content empty and load it via ajax
        }else{
            $content =  st_user_get_content( st_user_get_template('login.php') );
        }
        $html = '<div '.st_user_array_to_html_atts( $atts ).' class="st-user-wrapper st-login-wrapper">'.$content.'</div>';
        return $html;
    }

    function register( $atts, $content = "" ){

        $atts = shortcode_atts(array(
            'ajax_load' => 'true' ,
            'redirect' => '', // page id or url
        ), $atts );
        $atts['action'] = 'register-template';
        extract(  $atts );
        $content ='';
        if(  st_is_true ( $atts['ajax_load'] ) ){
            // leave content empty and load it via ajax
        }else{
            $content =  st_user_get_content( st_user_get_template('register.php') );
        }

        return '<div class="st-user-wrapper st-register-wrapper" '.st_user_array_to_html_atts( $atts ).'>'.$content.'</div>';
    }

    function lost_password( $atts, $content = "" ){

        $atts = shortcode_atts(array(
            'ajax_load' => 'true' ,
        ), $atts );
        $atts['action'] = 'lostpwd-template';
        extract(  $atts );

        return '<div class="st-user-wrapper st-lost-password" '.st_user_array_to_html_atts( $atts ).'>ST USER lost_password</div>';
    }

    function reset_password( $atts, $content = "" ){

        $atts = shortcode_atts(array(
            'ajax_load' => 'true' ,
            'redirect' => '', // page id or url
        ), $atts );
        $atts['action'] = 'reset-template';
        extract(  $atts );
        $content ='';
        if(  st_is_true ( $atts['ajax_load'] ) ){
            // leave content empty and load it via ajax
        }else{
            $content =  st_user_get_content( st_user_get_template('reset.php') );
        }

        return '<div class="st-user-wrapper st-reset-password-wrapper" '.st_user_array_to_html_atts( $atts ).'>'.$content.'</div>';
    }

    function profile( $atts, $content = "" ){

        $atts = shortcode_atts(array(
            'ajax_load' => 'true' ,
            'redirect' => '', // page id or url
        ), $atts );
        $atts['action'] = 'profile-template';
        extract(  $atts );
        $content ='';
        if(  st_is_true ( $atts['ajax_load'] ) ){
            // leave content empty and load it via ajax
        }else{
            $content =  st_user_get_content( st_user_get_template('reset.php') );
        }
        return '<div class="st-user-wrapper st-profile-wrapper" '.st_user_array_to_html_atts( $atts ).'>'.$content.'</div>';
    }

    function login_button( $atts ){
        $atts = shortcode_atts(array(
            'class' => '' ,
            'login_text' => __('Login', 'st-user'),
            'logout_text' => __("Logout", 'st-user'),
        ), $atts );
        extract(  $atts );
        $atts['class'].=' st-login-btn';
        $url = get_permalink();
        if( is_user_logged_in() ){
            $atts['is_logged'] = 'true';
            $url =  wp_logout_url( $url );
            $text = $logout_text;
        }else{
            $atts['is_logged'] = 'false';
            $text = $login_text;
        }
        return  '<a href="'.$url.'" '.st_user_array_to_html_atts( $atts ).'>'.$text.'</a>';
    }

    function singup_button( $atts ){
        $atts = shortcode_atts(array(
            'class' => '' ,
            'hide_when_logged' =>  'true' ,
            'text' => __('Singup', 'st-user'),
            'ajax'=> 'true'
        ), $atts );
        extract(  $atts );
        $atts['class'].=' st-singup-btn';

        if( ! st_is_true( $ajax ) ){
            $url = get_permalink();
            $url =  add_query_arg( array('logout'=>'true') , $url );
        }else{
            $url ='#';
        }
        return  '<a href="'.$url.'" '.st_user_array_to_html_atts( $atts ).'>'.$text.'</a>';
    }

}

add_shortcode( 'st_user_login', array( 'ST_User_Shortcodes', 'login' ) );
add_shortcode( 'st_user_register', array( 'ST_User_Shortcodes', 'register' ) );
add_shortcode( 'st_user_lost_password', array( 'ST_User_Shortcodes', 'lost_password' ) );
add_shortcode( 'st_user_reset_password', array( 'ST_User_Shortcodes', 'reset_password' ) );
add_shortcode( 'st_user_profile', array( 'ST_User_Shortcodes', 'profile' ) );
add_shortcode( 'st_login_btn', array( 'ST_User_Shortcodes', 'login_button' ) );
add_shortcode( 'st_singup_btn', array( 'ST_User_Shortcodes', 'singup_button' ) );