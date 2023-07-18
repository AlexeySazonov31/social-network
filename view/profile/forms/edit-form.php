<form action="" method="POST">
    <!-- name -->
    <div class="mb-3">
        <label for="InputName" class="form-label">Name</label>
        <input class="form-control" type="text" name="name" placeholder="name" minlength="2" maxlength="15" pattern="[A-Za-z]+" value="<?= $data["name"] ?>" required />
        <div class="form-text">Please enter your name to update.</div>
    </div>
    <!-- surname -->
    <div class="mb-3">
        <label for="InputSurname" class="form-label">Surname</label>
        <input class="form-control" type="text" name="surname" placeholder="surname" minlength="2" maxlength="15" pattern="[A-Za-z]+" value="<?= $data["surname"] ?>" required />
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