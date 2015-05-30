
<div class="st-user-modal"> <!-- this is the entire modal form, including the background -->
    <div class="st-user-modal-container"> <!-- this is the container wrapper -->
        <ul class="st-switcher">
            <li><a href="#0">Sign in</a></li>
            <li><a href="#0">New account</a></li>
        </ul>

        <div id="st-login"> <!-- log in form -->
            <form class="st-form">
                <p class="fieldset">
                    <label class="image-replace st-email" for="signin-email">E-mail</label>
                    <input class="full-width has-padding has-border" id="signin-email" type="email" placeholder="E-mail">
                    <span class="st-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace st-password" for="signin-password">Password</label>
                    <input class="full-width has-padding has-border" id="signin-password" type="text"  placeholder="Password">
                    <a href="#0" class="hide-password">Hide</a>
                    <span class="st-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <input type="checkbox" id="remember-me" checked>
                    <label for="remember-me">Remember me</label>
                </p>

                <p class="fieldset">
                    <input class="full-width" type="submit" value="Login">
                </p>
            </form>

            <p class="st-form-bottom-message"><a href="#0">Forgot your password?</a></p>
            <!-- <a href="#0" class="st-close-form">Close</a> -->
        </div> <!-- st-login -->

        <div id="st-signup"> <!-- sign up form -->
            <form class="st-form">
                <p class="fieldset">
                    <label class="image-replace st-username" for="signup-username">Username</label>
                    <input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="Username">
                    <span class="st-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace st-email" for="signup-email">E-mail</label>
                    <input class="full-width has-padding has-border" id="signup-email" type="email" placeholder="E-mail">
                    <span class="st-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace st-password" for="signup-password">Password</label>
                    <input class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="Password">
                    <a href="#0" class="hide-password">Hide</a>
                    <span class="st-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <input type="checkbox" id="accept-terms">
                    <label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
                </p>

                <p class="fieldset">
                    <input class="full-width has-padding" type="submit" value="Create account">
                </p>
            </form>

            <!-- <a href="#0" class="st-close-form">Close</a> -->
        </div> <!-- st-signup -->

        <div id="st-reset-password"> <!-- reset password form -->
            <p class="st-form-message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>

            <form class="st-form">
                <p class="fieldset">
                    <label class="image-replace st-email" for="reset-email">E-mail</label>
                    <input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail">
                    <span class="st-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <input class="full-width has-padding" type="submit" value="Reset password">
                </p>
            </form>

            <p class="st-form-bottom-message"><a href="#0">Back to log-in</a></p>
        </div> <!-- st-reset-password -->
        <a href="#0" class="st-close-form">Close</a>
    </div> <!-- st-user-modal-container -->
</div> <!-- st-user-modal -->