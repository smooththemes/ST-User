<?php

class ST_User_Action{

    public  static function do_login(){
        $creds = array();
        $creds['user_login'] = $_POST['st_username'];
        $creds['user_password'] = $_POST['st_pwd'];
        $creds['remember'] = isset( $_POST['st_rememberme'] )  && $_POST['st_rememberme'] !='' ? true :  false;
        $user = wp_signon( $creds, true );
        if ( is_wp_error($user) ){
            $codes = $user->get_error_codes();
            $msgs = array();
            foreach( $codes as $code ){
                switch( $code ){
                    case 'invalid_username':
                        $msgs['invalid_username'] =  __('<strong>ERROR</strong>: Invalid username.', 'st-user');
                        break;
                    case 'incorrect_password':
                        $msgs['incorrect_password'] =  __('<strong>ERROR</strong>: The password you entered for the username <strong>admin</strong> is incorrect.', 'st-user');
                        break;
                }
            }
            echo json_encode( $msgs );
        }else{
            echo 'logged_success';
        }

    }

}