<form action="" method="POST">
    <!-- name -->
    <div class="mb-3">
        <label for="InputName" class="form-label">Name for Question</label>
        <input class="form-control" type="text" name="name" placeholder="question name" minlength="6" maxlength="50" value="<?= $_POST["name"] ?? "" ?>" required />
        <div class="form-text">Please enter short name for your Question!</div>
    </div>    
    <!-- content -->
    <div class="mb-3">
        <label for="InputContent" class="form-label">Content Question</label>
        <textarea class="form-control" rows="10" cols="45" name="content" placeholder="Question?" minlength="15" required ><?= $_POST["content"] ?? "" ?></textarea>
        <div class="form-text">Please describe your question in detail!</div>
    </div>

    <input class="btn btn-primary" type="submit" name="submit" value="Ask Question" />

</form>