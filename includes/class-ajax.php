<?php

class ST_User_Ajax{

    function __construct(){
        add_action( 'wp_ajax_st_user_ajax',  array(  $this, 'ajax' ) );
        add_action( 'wp_ajax_nopriv_st_user_ajax', array(  $this, 'ajax' ) );
    }

    function ajax(){
        $act = $_REQUEST['act'];
        switch( $act ){
            case 'login-template':
                echo st_user_get_content( st_user_get_template('login.php') );
                break;
            case 'register-template':
                echo st_user_get_content( st_user_get_template('register.php') );
                break;
            case 'lostpwd-template':
                echo st_user_get_content( st_user_get_template('lost-password.php') );
                break;
            case 'reset-template':
                echo st_user_get_content( st_user_get_template('reset.php') );
                break;
            case 'profile-template':
                echo st_user_get_content( st_user_get_template('profile.php') );
                break;
            case 'modal-template':
                echo st_user_get_content( st_user_get_template('modal.php') );
                break;
            case 'do_login':
                ST_User_Action::do_login();
                break;
        }
        exit();
    }
}
new ST_User_Ajax;