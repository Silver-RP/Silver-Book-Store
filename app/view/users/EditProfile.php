<section class="container edit-profile-container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Edit Profile</h1>
            <form action="?route=user&subroute=edit" method="post">
                <div class="form-group">
                    <label for="user_name" class="fw-bold">Name:</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $user['user_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="user_birthday" class="fw-bold">Birth Day:</label>
                    <input type="date" class="form-control" id="user_birthday" name="user_birthday" value="<?php echo $user['user_birthday']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="user_gender" class="fw-bold">Gender:</label>
                    <select class="form-control" id="user_gender" name="user_gender" required>
                        <option value="Male" <?php if ($user['user_gender'] == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($user['user_gender'] == 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Other" <?php if ($user['user_gender'] == 'Other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="user_email_phone" class="fw-bold">Email/Phone:</label>
                    <input type="text" class="form-control" id="user_email_phone" name="user_email_phone" value="<?php echo $user['user_email']; ?>" readonly>
                </div>
                <div class="buttons">
                    <button class="btn btn-custom-left btn-outline-secondary" name="edit">Save</button>
                    <a href="?route=user&subroute=profile" class="btn btn-custom-left btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>