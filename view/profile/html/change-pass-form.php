<form action="" method="POST">
    <!-- old password -->
    <div class="mb-3">
        <label for="InputPassword" class="form-label">Old Password</label>
        <input class="form-control" type="password" name="password" placeholder="old password" required />
        <div class="form-text">Please enter your old password!</div>
    </div>
    <!-- new password -->
    <div class="mb-3">
        <label for="InputPassword" class="form-label">New Password</label>
        <input class="form-control" type="password" name="new_password" placeholder="new password" minlength="6" maxlength="12" required />
        <div class="form-text">Please enter your your New password!</div>
    </div>
    <!-- new password confirm -->
    <div class="mb-3">
        <label for="InputPassword" class="form-label">Confirm New Password</label>
        <input class="form-control" type="password" name="new_password_confirm" placeholder="new password confirm" minlength="6" maxlength="12" required />
        <div class="form-text">Please confirm your new password!</div>
    </div>
    <input class="btn btn-warning" type="submit" name="submit" value="Change Password" />
</form>