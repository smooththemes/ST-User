
<div class="st-user-modal"> <!-- this is the entire modal form, including the background -->
    <div class="st-user-modal-container"> <!-- this is the container wrapper -->
        <ul class="st-switcher">
            <li><a href="#0"><?php _e('Sign in', 'st-user');  ?></a></li>
            <li><a href="#0"><?php _e('New account','st-user'); ?></a></li>
        </ul>
        <?php
        echo st_user_get_content( st_user_get_template('login.php') );
        echo st_user_get_content( st_user_get_template('register.php') );
        echo st_user_get_content( st_user_get_template('reset.php') );
        ?>
        <a href="#0" class="st-close-form"><?php _e('Close','st-user'); ?></a>
    </div> <!-- st-user-modal-container -->
</div> <!-- st-user-modal -->