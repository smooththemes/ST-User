//
// Use internal $.serializeArray to get list of form elements which is
// consistent with $.serialize
//
// From version 2.0.0, $.serializeObject will stop converting [name] values
// to camelCase format. This is *consistent* with other serialize methods:
//
//   - $.serialize
//   - $.serializeArray
//
// If you require camel casing, you can either download version 1.0.4 or map
// them yourself.
//

(function($){
    $.fn.serializeObject = function () {
        "use strict";

        var result = {};
        var extend = function (i, element) {
            var node = result[element.name];

            // If node with same name exists already, need to convert it to an array as it
            // is a multi-value field (i.e., checkboxes)

            if ('undefined' !== typeof node && node !== null) {
                if ($.isArray(node)) {
                    node.push(element.value);
                } else {
                    result[element.name] = [node, element.value];
                }
            } else {
                result[element.name] = element.value;
            }
        };

        $.each(this.serializeArray(), extend);
        return result;
    };
})(jQuery);


jQuery(document).ready(function($){

    $('.st-user-wrapper').each(function(){
        var w = $(this);
        var _act = w.data('action');
        var data = { action :'st_user_ajax', 'act' : _act };
        $.ajax({
            data: data,
            url: ST_User.ajax_url,
            type: 'GET',
            success: function(  html ){
                html = $( html );
                w.html( html );
                __init( html  );
            }
        });
    });

    // load singup modal

    $('.st-singup-btn, .st-login-btn').click( function( event ){
        var target = $( event.target );
        var is_login = target.is('.st-login-btn');

        if($('.st-user-modal').length > 0 ){
            $('.st-user-modal').addClass('is-visible');
            $('body').trigger('st_user_before_open');
            if( is_login ){
                $('body').trigger('login_selected');
            }else{
                $('body').trigger('signup_selected');
            }

        }else{
            var data = { action :'st_user_ajax', 'act' : 'modal-template' };
            $.ajax({
                data: data,
                url: ST_User.ajax_url,
                type: 'GET',
                success: function(  html ){
                    html = $( html );
                    $('body').append( html );
                    __init( html );
                    $('body').trigger('st_user_before_open');
                    $('.st-user-modal').addClass('is-visible');
                    if( is_login ){
                        $('body').trigger('login_selected');
                    }else{
                        $('body').trigger('signup_selected');
                    }
                }
            });
        }
        if( is_login  ){
            if( target.data('is-logged') ){
                return true;
            }
        }
        return false;
    } );


    __init();
	function __init( w ){
        if( typeof w === 'undefined' ){
            w = $('body');
        }
        var $form_modal = ( $('.st-user-modal' , w).length >0 )  ?  $('.st-user-modal' , w) :  $('.st-user-modal'),
            $form_login = $form_modal.find('#st-login'),
            $form_signup = $form_modal.find('#st-signup'  ),
            $form_forgot_password = $form_modal.find('#st-reset-password'),
            $form_modal_tab = $('.st-switcher', w ),
            $tab_login = $form_modal_tab.children('li').eq(0).children('a'),
            $tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
            $forgot_password_link = $form_login.find('.st-form-bottom-message a'),
            $back_to_login_link = $form_forgot_password.find('.st-form-bottom-message a');


        $('body').on('st_user_before_open', function(){
            hide_all_errors();
        });
        $('body').on('signup_selected', function(){
            signup_selected();
        });
        $('body').on('login_selected', function(){
            login_selected();
        });
        $('body').on('forgot_password_selected', function(){
            forgot_password_selected();
        });
        //close modal
        $('.st-user-modal').on('click', function(event){
            if( $(event.target).is($form_modal) || $(event.target).is('.st-close-form') ) {
                $form_modal.removeClass('is-visible');
            }
        });
        //close modal when clicking the esc keyboard button
        $(document).keyup(function(event){
            if(event.which=='27'){
                $form_modal.removeClass('is-visible');
            }
        });

        //switch from a tab to another
        $form_modal_tab.on('click', function(event) {
            event.preventDefault();
            ( $(event.target).is( $tab_login ) ) ? login_selected() : signup_selected();
            return false;
        });

        //hide or show password
        $('.hide-password').on('click', function(){
            var $this= $(this),
                $password_field = $this.prev('input');

            ( 'password' == $password_field.attr('type') ) ? $password_field.attr('type', 'text') : $password_field.attr('type', 'password');
            ( 'Hide' == $this.text() ) ? $this.text('Show') : $this.text('Hide');
            //focus and move cursor to the end of input field
            $password_field.putCursorAtEnd();
            return false;
        });

        //show forgot-password form
        $forgot_password_link.on('click', function(event){
            event.preventDefault();
            forgot_password_selected();
            return false;
        });

        //back to login from the forgot-password form
        $back_to_login_link.on('click', function(event){
            event.preventDefault();
            login_selected();
            return false;
        });

        function login_selected(){
            $form_login.addClass('is-selected');
            $form_signup.removeClass('is-selected');
            $form_forgot_password.removeClass('is-selected');
            $tab_login.addClass('selected');
            $tab_signup.removeClass('selected');
        }

        function signup_selected(){
            $form_login.removeClass('is-selected');
            $form_signup.addClass('is-selected');
            $form_forgot_password.removeClass('is-selected');
            $tab_login.removeClass('selected');
            $tab_signup.addClass('selected');
        }

        function forgot_password_selected(){
            $form_login.removeClass('is-selected');
            $form_signup.removeClass('is-selected');
            $form_forgot_password.addClass('is-selected');
        }

        function hide_all_errors(){
            // hide all errors fields when load
            $('.st-form .fieldset' ).click( function( ){
                var p = $(this);
                p.find('input').removeClass('has-error');
                p.find('span').removeClass('is-visible');
            });
        }


        // hide error of input field
        $('.st-form .fieldset input', w ).click( function( ){
            var p = $(this).parents('.fieldset');
            $(this).removeClass('has-error');
            p.find('span').removeClass('is-visible');
        });


        //-------------------------------------------------
        //  Login form submit

        $('.st-login-form', w ).submit( function(){
            var form = $(this);
            var formData = form.serializeObject();
            formData.action = 'st_user_ajax';
            formData.act = 'do_login';
            $.ajax({
                url: ST_User.ajax_url,
                data: formData,
                type: 'POST',
                success: function( response ){
                    if( response === 'logged_success' ){
                        var redirect_url = ( typeof formData.st_redirect_to !== undefined  & formData.st_redirect_to != '' ) ? formData.st_redirect_to : window.location;
                        window.location = redirect_url;
                        return ;
                    }else{
                        var res = JSON.parse( response);
                        if( typeof res !== 'undefined' ){
                            if( typeof res.incorrect_password !== 'undefined' ){
                                var  p = $('.st-pwd', form );
                                $('.st-error-message', p).html( res.incorrect_password );
                                p.find('input[name="st_pwd"]').toggleClass('has-error');
                                p.find('span').toggleClass('is-visible');
                            }

                            if( typeof res.invalid_username !== 'undefined' ){
                                var  p = $('.st-username', form );
                                $('.st-error-message', p).html( res.invalid_username );
                                p.find('input[name="st_username"]').toggleClass('has-error');
                                p.find('span').toggleClass('is-visible');
                            }
                        }
                    }

                }
            });
            return false;
        } );

        // Register Form submit
        //console.debug(  $('.st-register-form' , w ) );
        $('.st-register-form' , w ).submit( function(){
            var form = $(this);
            //alert('ok');
            var formData = form.serializeObject();
            formData.action = 'st_user_ajax';
            formData.act = 'do_register';
            $.ajax({
                url: ST_User.ajax_url,
                data: formData,
                type: 'POST',
                success: function( response ){
                    if(  !isNaN( response ) ){ // success - user created.
                        var redirect_url = ( typeof formData.st_redirect_to !== undefined  & formData.st_redirect_to != '' ) ? formData.st_redirect_to : window.location;
                        window.location = redirect_url;
                        return ;
                    }else{

                        var res = JSON.parse( response );
                        if( typeof res !== 'undefined' ){
                            if( typeof res.incorrect_email !== 'undefined'  ||  typeof res.existing_user_email !== 'undefined'){
                                var  p = $('.st-email', form );
                                var msg = res.incorrect_password || res.existing_user_email;
                                $('.st-error-message', p).html( msg );
                                p.find('input[name="st_signup_email"]').toggleClass('has-error');
                                p.find('span').toggleClass('is-visible');
                            }

                            if(
                                typeof res.invalidate_username !== 'undefined'
                                || typeof res.empty_user_login !== 'undefined'
                                || typeof res.existing_user_login !== 'undefined'

                            ){
                                var  p = $('.st-username', form );
                                var msg = res.invalidate_username
                                    || res.empty_user_login
                                    || res.existing_user_login;
                                $('.st-error-message', p).html( msg );
                                p.find('input[name="st_username"]').toggleClass('has-error');
                                p.find('span').toggleClass('is-visible');
                            }

                            if( typeof res.incorrect_password !== 'undefined' ){
                                var  p = $('.st-password', form );
                                $('.st-error-message', p).html( res.incorrect_password );
                                p.find('input[name="st_signup_password"]').toggleClass('has-error');
                                p.find('span').toggleClass('is-visible');
                            }
                        }
                    }
                }
            });
            return false;
        } );
        //-------------------------------------------------


        //IE9 placeholder fallback
        //credits http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
        if(!Modernizr.input.placeholder){
            $('[placeholder]').focus(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            }).blur(function() {
                var input = $(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.val(input.attr('placeholder'));
                }
            }).blur();
            $('[placeholder]').parents('form').submit(function() {
                $(this).find('[placeholder]').each(function() {
                    var input = $(this);
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                })
            });
        }

    }// end function init

});


//credits http://css-tricks.com/snippets/jquery/move-cursor-to-end-of-textarea-or-input/
jQuery.fn.putCursorAtEnd = function(  ) {
	return this.each(function() {
    	// If this function exists...
    	if (this.setSelectionRange) {
      		// ... then use it (Doesn't work in IE)
      		// Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
      		var len = jQuery(this).val().length * 2;
      		this.setSelectionRange(len, len);
    	} else {
    		// ... otherwise replace the contents with itself
    		// (Doesn't work in Google Chrome)
            jQuery(this).val(jQuery(this).val());
    	}
	});
};