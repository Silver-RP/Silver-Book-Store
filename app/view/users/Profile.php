<section class="container profile-container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Profile</h1>
            <p>Welcome to your profile page, <?php echo $user['user_name']; ?>!</p>
            <div class=" ps-3 ms-5">

                <table class="profile-table">
                    <tr>
                        <td>Name:</td>
                        <td><?php echo $user['user_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Birth Day:</td>
                        <td><?php echo $user['user_birthday']; ?></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td><?php echo $user['user_gender']; ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?php echo $user['user_email']; ?></td>
                    </tr>
                </table>
                <div class="buttons btn-prfile">
                    <a href="?route=user&subroute=viewEditprofile" class="btn btn-custom-left btn-outline-secondary">Edit</a>
                    <a href="?route=user&subroute=changepass" class="btn btn-custom-left btn-outline-secondary">Change Password</a>
                    <!-- <button class="btn btn-custom-left btn-outline-secondary" onclick="location.href='edit_profile.php'">Edit</button> -->
                    <!-- <button class="btn btn-custom-right btn-outline-secondary" onclick="location.href='change_password.php'">Change Password</button> -->
                </div>
            </div>
        </div>
    </div>
</section>