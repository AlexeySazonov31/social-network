<img id="output" src="https://cdn-icons-png.flaticon.com/512/1144/1144709.png" class="mb-5 avatar" alt="avatar">
<form action="" method="POST" enctype="multipart/form-data">
    <!-- avatar -->
    <div class="mb-3">
        <label for="InputFile" class="form-label">Avatar</label>
        <input class="form-control" accept="image/*" id="imgInp" type="file" name="avatar" onchange="loadFile(event)" required />
        <div class="form-text">Please select image.</div>
    </div>
    <!-- name -->
    <div class="mb-3">
        <label for="InputName" class="form-label">Your Name</label>
        <input class="form-control" type="text" name="name" placeholder="name" minlength="2" maxlength="10" pattern="[A-Za-z]+" value="<?= $_POST["name"] ?? "" ?>" required />
        <div class="form-text">Please enter your name.</div>
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

<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    if( event.target.files[0] ){
        output.src = URL.createObjectURL(event.target.files[0]);
    } else {
        output.src = "https://cdn-icons-png.flaticon.com/512/1144/1144709.png";
    }
    output.onload = function() {
      URL.revokeObjectURL(output.src)
    }
  };
</script>