<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    ST_User
 * @subpackage ST_User/admin/partials
 */
?>
<h2>ST User Settings</h2>

<form novalidate="novalidate" action="" method="post">
    <input type="hidden" value="general" name="option_page"><input type="hidden" value="update" name="action"><input type="hidden" value="b2e9ecd063" name="_wpnonce" id="_wpnonce"><input type="hidden" value="/wp-plugins/wp-admin/options-general.php" name="_wp_http_referer">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><label for="default_role"><?php _e('Account page') ?></label></th>
            <td>
                <select id="default_role" name="default_role">
                    <option value="subscriber" selected="selected">Subscriber</option>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row">Login</th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span>Login</span></legend>
                    <label >
                        <input type="checkbox" checked="checked" value="1"  name="users_can_register">
                        User Account page as login page.
                    </label>
                    <p class="description">Default login page of WordPress will disable.</p>
                </fieldset>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="logout-redirect-url">Logout Redirect (URL)</label></th>
            <td>
                <input type="text" class="regular-text" value="" id="logout-redirect-url" name="blogname">
                <p class="description">The url will redirect when you logout, leave empty to redirect home page.</p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="blogdescription">Tagline</label></th>
            <td><input type="text" class="regular-text" value="Just another WordPress site" aria-describedby="tagline-description" id="blogdescription" name="blogdescription">
                <p id="tagline-description" class="description">In a few words, explain what this site is about.</p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="siteurl">WordPress Address (URL)</label></th>
            <td><input type="url" class="regular-text code" value="http://localhost/wp-plugins" id="siteurl" name="siteurl"></td>
        </tr>
        <tr>
            <th scope="row"><label for="home">Site Address (URL)</label></th>
            <td><input type="url" class="regular-text code" value="http://localhost/wp-plugins" aria-describedby="home-description" id="home" name="home">
                <p id="home-description" class="description">Enter the address here if you <a href="https://codex.wordpress.org/Giving_WordPress_Its_Own_Directory">want your site home page to be different from your WordPress installation directory.</a></p></td>
        </tr>
        <tr>
            <th scope="row"><label for="admin_email">E-mail Address </label></th>
            <td>
                <input type="email" class="regular-text ltr" value="shrimp2t@gmail.com" aria-describedby="admin-email-description" id="admin_email" name="admin_email">
                <p id="admin-email-description" class="description">This address is used for admin purposes, like new user notification.</p>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="start_of_week">Week Starts On</label></th>
            <td><select id="start_of_week" name="start_of_week">

                    <option value="0">Sunday</option>
                    <option selected="selected" value="1">Monday</option>
                    <option value="2">Tuesday</option>
                    <option value="3">Wednesday</option>
                    <option value="4">Thursday</option>
                    <option value="5">Friday</option>
                    <option value="6">Saturday</option>
                </select>
            </td>
        </tr>

        </tbody>
    </table>

    <p class="submit">
        <input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
    </p>
</form>

