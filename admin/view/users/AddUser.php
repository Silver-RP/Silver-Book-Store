<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom">
        <h2>Add User</h2>
    </div>
    <section class="container m-5">
        <div class="container d-flex justify-content-center">
            <div class="col-4 ps-5">
                <h2 class="me-5">Create a user:</h2>
            </div>
            <div class="col-8"> 
                <div class="cf">
                    <form action="" method="POST">
                        <!-- Name -->
                        <div class="form-add-user">
                            <label for="name" class="label-add-user">Your Name:</label>
                            <input type="text" id="name" name="name" required class="input-add-user" placeholder="Enter Your First Name and Last Name">
                        </div>
                        <!-- Birth day -->
                        <div class="form-add-user">
                            <label for="birthday" class="label-add-user">Birthday:</label>
                            <input type="date" id="birthday" name="birthday" required class="input-add-user">
                        </div>
                        <!-- Gender -->
                        <div class="form-add-user ">
                            <label for="gender" class="label-add-user gender-add">Gender:</label><br>
                            <div class="gender-select-add-user">
                                <label for="male" class="inline-label-add">
                                    <input type="radio" id="male" name="gender" value="Male" checked>
                                    Male
                                </label>
                                <label for="female" class="inline-label-add">
                                    <input type="radio" id="female" name="gender" value="Female">
                                    Female
                                </label>
                                <label for="other" class="inline-label-add">
                                    <input type="radio" id="other" name="gender" value="Other">
                                    Other
                                </label>
                                <label for="prefer_not_to_say" class="inline-label-add">
                                    <input type="radio" id="prefer_not_to_say" name="gender" value="Prefer_not_to_say">
                                    Prefer not to say
                                </label>
                            </div>
                        </div>
                        <!-- Email or Phone -->
                        <div class="form-add-user">
                            <label for="emailPhone" class="label-add-user">Email or Phone number:</label>
                            <input type="text" id="emailPhone" name="emailPhone" required class="input-add-user" placeholder="Enter Your Email or Phone Number">
                            <span id="emailPhoneFeedback" name="emailPhoneFeedback"></span>
                        </div>
                        <!-- Password -->
                        <div class="form-add-user">
                            <label for="password" class="label-add-user">Password:</label>
                            <input type="password" id="password" name="password" required class="input-add-user ip-pa" placeholder="Enter Your Password">
                            <i style="font-size:x-small; margin-left:5px"><span class="text-info">𝒊𝒊</span> Passwords must be at least 8 characters.</i>
                        </div>
                        <!-- Re-Password -->
                        <div class="form-add-user">
                            <label for="re_password" class="label-add-user">Re-enter Password:</label>
                            <input type="password" id="re_password" name="re_password" required class="input-add-user" placeholder="Enter Your Re-Password">
                        </div>
                        <!-- Role -->
                        <div class="form-add-user">
                            <label for="role" class="label-add-user">Role:</label>
                            <select id="role" name="role" class="input-add-user select-role">
                                <option value="0">0 - Admin</option>
                                <option value="1">1 - User</option>
                                <option value="2">2 - Editor</option>
                            </select>
                        </div>
                        <!-- Button -->
                        <button type="submit" class="btn btn-warning btn-add-user" name="add">Signup</button>
                        <a href="?act=user&action=index" class="btn btn-secondary btn-add-user">Cancel</a>
                        <hr>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>