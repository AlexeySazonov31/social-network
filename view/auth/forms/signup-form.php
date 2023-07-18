<form action="" method="POST" enctype="multipart/form-data">
    <!-- avatar -->
    <img class="w-25 mb-5" src="https://cdn-icons-png.flaticon.com/512/1144/1144709.png" alt="profile icon" />
    <div class="mb-3">
        <label for="InputName" class="form-label">Avatar</label>
        <input type="file" class="form-control" name="file" id="customFile" required />
        <div class="form-text">Please select image.</div>
    </div>
    <!-- name -->
    <div class="mb-3">
        <label for="InputName" class="form-label">Your Name</label>
        <input class="form-control" type="text" name="name" placeholder="name" minlength="2" maxlength="10" pattern="[A-Za-z]+" value="<?= $_POST["name"] ?? "" ?>" required />
        <div class="form-text">Please enter your name.</div>
    </div>
    <!-- surname -->
    <div class="mb-3">
    <label for="InputSurname" class="form-label">Your Surname</label>
    <input class="form-control" type="text" name="surname" placeholder="surname" minlength="2" maxlength="10" pattern="[A-Za-z]+" value="<?= $_POST["surname"] ?? "" ?>" required />
    <div class="form-text">Please enter your surname.</div>
    </div>
    <!-- birthday -->
    <div class="mb-3">
    <label for="InputBirthday" class="form-label">Your Birthday</label>
    <input class="form-control" type="date" name="bd" placeholder="birthday" value="<?= $_POST["bd"] ?? "" ?>" required />
    <div class="form-text">Please enter your birthday.</div>
    </div>
    <!-- email -->
    <div class="mb-3">
    <label for="InputEmail" class="form-label">Your Email</label>
    <input class="form-control" type="email" name="email" placeholder="email" value="<?= $_POST["email"] ?? "" ?>" required />
    <div class="form-text">Please enter your email.</div>
    </div>
    <!-- login -->
    <div class="mb-3">
    <label for="InputLogin" class="form-label">Login</label>
    <input class="form-control" type="text" name="login" placeholder="login" minlength="6" maxlength="15" pattern="\w+" value="<?= $_POST["login"] ?? "" ?>" required />
    <div class="form-text">Please enter your login.</div>
    </div>
    <!-- password -->
    <div class="mb-3">
    <label for="InputPassword" class="form-label">Password</label>
    <input class="form-control" type="password" name="password" placeholder="password" minlength="6" maxlength="12" value="<?= $_POST["password"] ?? "" ?>" required />
    <div class="form-text">Please enter password.</div>
    </div>
    <!-- confirm password -->
    <div class="mb-3">
    <label for="InputName" class="form-label">Confirm Password</label>
    <input class="form-control" type="password" name="confirm" placeholder="confirm password" minlength="6" maxlength="20" value="<?= $_POST["confirm"] ?? "" ?>" required />
    <div class="form-text">Please confirm your password.</div>
    </div>
    <input class="btn btn-primary" type="submit" name="submit" />
</form>