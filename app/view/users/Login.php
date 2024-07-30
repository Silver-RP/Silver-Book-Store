<section class="container m-5">
    <div class="container d-flex justify-content-center">
        <h2 class="me-5">Signin</h2>
        <div class="cf ">
            <form action="?route=user&subroute=signin" method="POST">
                <!-- Username: Email or Phone -->
                <div class="form-group-signin">
                    <label for="emailPhone" class="label-signin">Email or Phone number:</label>
                    <input type="text" id="emailPhone" name="emailPhone" required class="input-signin"
                    placeholder="Enter Your Email or Phone Number">
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
                    <!-- <label for="password" class="label-signin">Password:</label>
                    <input type="password" id="password" name="password" required class="input-signin ip-pa"
                    placeholder="Enter Your Password"> -->
                </div>
                <!-- Button -->
                <button type="submit" class="btn btn-warning btn-signin1 my-3" name="signin">Sign in</button>

                <pre>By signing up, you agree to our <a href="#">Terms</a>, 
<a href="#">Data Policy</a> and <a href="#">Cookies Policy</a>.</pre>
                <hr>
                <pre>Don't have an account? <a href="?route=user&subroute=viewsignup">Sign up</a></pre>
                <hr>
                <pre>Need help? <a href="?route=user&subroute=forgotPassword">Click here</a></pre>
            </form>
        </div>
    </div>
   
</section>