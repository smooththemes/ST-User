<?php

class ST_User_Action{

    public  static function do_login(){
        $creds = array();
        $creds['user_login'] = $_POST['st_username'];
        $creds['user_password'] = $_POST['st_pwd'];

        $msgs = array();
        if( trim( $creds['user_login'] ) == '' ){
            $msgs['invalid_username'] =  __('<strong>ERROR</strong>: Invalid username.', 'st-user');
        }

        if( trim( $creds['user_password'] ) == '' ){
            $msgs['incorrect_password'] =  __('<strong>ERROR</strong>: The password you entered for the username <strong>admin</strong> is incorrect.', 'st-user');
        }

        if( !empty( $msgs ) ){
            return (  json_encode( $msgs ) );
        }

        $creds['remember'] = isset( $_POST['st_rememberme'] )  && $_POST['st_rememberme'] !='' ? true :  false;
        $user = wp_signon( $creds, true );
        if ( is_wp_error($user) ){
            $codes = $user->get_error_codes();

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
            return json_encode( $msgs );
        }else{
            return 'logged_success';
        }

    }

    public static function do_register(){
        $email = $_POST['st_signup_email'];
        $pwd =  $_POST['st_signup_password'];
        $username =  $_POST['st_signup_username'];


        $msgs = array();
        $pwd_leng =  apply_filters('st_user_pwd_leng', 6 );
        if(  empty( $username ) || ! validate_username( $username ) ){
            $msgs['invalidate_username'] = __('Invalidate username','st-user');
        }
        if( strlen( $pwd ) < $pwd_leng ){
            $msgs['incorrect_password'] = sprintf( __('Please enter your password more than %s characters', 'st-user'),  $pwd_leng );
        }
        if( !is_email( $email ) ){
            $msgs['incorrect_email'] =  __('Please enter a correct your email', 'st-user');
        }
        if( !empty (  $msgs ) ){
            return json_encode(  $msgs );
        }

        $r = wp_create_user( $username, $pwd , $email );
        if( is_wp_error( $r ) ){
            foreach ( (array) $r->errors as $code => $messages ) {
                $msgs[  $code ] = $messages;
            }
           return $msgs;
        }else{
            return $r;
        }

    }

}