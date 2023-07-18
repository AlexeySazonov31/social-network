<form action="" method="POST" enctype="multipart/form-data">
    <!-- avatar -->
    <div class="mb-3">
        <label for="InputFile" class="form-label">Avatar</label>
        <input class="form-control" accept="image/*" id="imgInp" type="file" name="avatar" onchange="loadFile(event)" />
        <div class="form-text">Please select image.</div>
    </div>
    <!-- name -->
    <div class="mb-3">
        <label for="InputName" class="form-label">Name</label>
        <input class="form-control" type="text" name="name" placeholder="name" minlength="2" maxlength="15" pattern="[A-Za-z]+" value="<?= $data["name"] ?>" required />
        <div class="form-text">Please enter your name to update.</div>
    </div>
    <!-- surname -->
    <div class="mb-3">
        <label for="InputSurname" class="form-label">Surname</label>
        <input class="form-control" type="text" name="surname" placeholder="surname" minlength="2" maxlength="15" pattern="[A-Za-z]+" value="<?= $data["surname"] ?>" />
        <div class="form-text">Please enter your surname to update.</div>
    </div>
    <!-- email -->
    <div class="mb-3">
        <label for="InputEmail" class="form-label">Email</label>
        <input class="form-control" type="email" name="email" placeholder="email" value="<?= $data["email"] ?>" required />
        <div class="form-text">Please enter your email to update.</div>
    </div>
    <input class="btn btn-warning" type="submit" name="submit" value="Update Account Data" />

</form>

<script>
  var loadFile = function(event) {
    var output = document.getElementById('avatar');
    if( event.target.files[0] ){
        output.src = URL.createObjectURL(event.target.files[0]);
    } else {
        output.src = "../../../uploads/<?= $data["avatar_name"] ?>";
    }
    output.onload = function() {
      URL.revokeObjectURL(output.src)
    }
  };
</script>