<section class="container m-5">
    <div class="container d-flex justify-content-center">
        <h2 class="me-5">Signup</h2>
        <div class="cf ">
            <form action="?route=user&subroute=signup" method="POST">
                <!-- Name -->
                <div class="form-group-signin">
                    <label for="name" class="label-signin">Your Name:</label>
                    <input type="text" id="name" name="name" required class="input-signin" 
                    placeholder="Enter Your Fisrt Name and Last Name">
                </div>
                <!-- Birth day -->
                <div class="form-group-signin">
                    <label for="birthday" class="label-signin">Birthday:</label>
                    <input type="date" id="birthday" name="birthday" required class="input-signin">
                </div>
                <!-- Gender -->
                <div class="form-group-signin">
                    <label for="gender" class="label-signin label-gender">Gender:</label><br>
                    <div class="fgs">
                        <label for="male" class="inline-label-signin">
                            <input type="radio" id="male" name="gender" value="male" checked>
                            Male
                        </label>
                        <label for="female" class="inline-label-signin">
                            <input type="radio" id="female" name="gender" value="female">
                            Female
                        </label>
                        <label for="other" class="inline-label-signin">
                            <input type="radio" id="other" name="gender" value="other">
                            Other
                        </label>
                        <label for="prefer_not_to_say" class="inline-label-signin">
                            <input type="radio" id="prefer_not_to_say" name="gender" value="prefer_not_to_say">
                            Prefer not to say
                        </label>
                    </div>
                </div>
                <!-- Email or Phone -->
                <div class="form-group-signin">
                    <label for="emailPhone" class="label-signin">Email:</label>
                    <input type="text" id="emailPhone" name="emailPhone" required class="input-signin"
                    placeholder="Enter Your Email">
                    <span id="emailPhoneFeedback" name = emailPhoneFeedback></span>
                </div>
                <!-- Password -->
                <div class="form-group-signin">
                    <div class="form-group-signin-eye">
                        <label for="password" class="label-signin">Password:</label>
                        <input type="password" id="password" name="password" required class="input-signin ip-pa"
                        placeholder="Enter Your Password">
                        <button type="button" class="toggle-password toggle-password-1">
                            <i class="fa-regular fa-eye"></i>
                            <i class="fa-solid fa-eye-slash" style="display: none;"></i>
                        </button>
                    </div>
                    <i style="font-size:x-small; margin-left:5px"><span class="text-info">𝒊𝒊</span>  Passwords must be at least 8 characters.</i>
                </div>
                <!-- Re-Password -->
                <div class="form-group-signin">
                    <div class="form-group-signin-eye">
                        <label for="re_password" class="label-signin">Re-enter Password:</label>
                        <input type="password" id="re_password" name="re_password" required class="input-signin"
                        placeholder="Enter Your Re-Password">
                        <button type="button" class="toggle-password ">
                            <i class="fa-regular fa-eye"></i>
                            <i class="fa-solid fa-eye-slash" style="display: none;"></i>
                        </button>
                    </div>
                    
                </div>
                <!-- Button -->
                <button type="submit" class="btn btn-warning btn-signin1" name="signup">Signup</button>

                <pre class="mt-3" style="margin-bottom: -15px !important;">By creating an account, you agree to Silver-Book 
<a href="#">Conditions of Use</a> and <a href="#">Privacy Notice</a>.
                </pre>
                <hr >
                <pre>Already have an account? <a href="?route=user&subroute=signin">Sign in</a></pre>
            </form>
        </div>
    </div>

</section>
