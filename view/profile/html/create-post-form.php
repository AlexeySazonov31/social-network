<style>
    #block-add-image {
        height: 0;
        transition: height 0.2s;
        overflow: hidden;
    }

    #block-add-image.active {
        height: 365px;
        transition: height 0.2s;
    }
    .post-image {
        width: 100%;
    }
    .create-post-h {
        position: absolute;
        top: 150px;
    }
</style>

<form action="" method="POST" enctype="multipart/form-data">
    <h3 class="create-post-h">Create Post</h3>
    <!-- button add image -->
    <button type="button" id="btn-image" class="btn btn-primary mb-2 w-100">Image Add/Remove</button>
    <div class="mb-3 w-100" id="block-add-image">
        <img id="output" src="https://via.placeholder.com/1080x500/CDCDCD/fff?text=Post+Image" class="my-2 post-image rounded-1 border-primary" alt="prev-img-post">
        <label for="InputFile" class="form-label">Post Image</label>
        <input class="form-control" accept="image/*" id="imgInp" type="file" name="post" onchange="loadFile(event)" />
    </div>
    <!-- content -->
    <div class="mb-3">
        <label for="InputName" class="form-label">Content</label>
        <textarea class="form-control" rows="2" cols="25" name="content-post" placeholder="Write post content" minlength="6" required ><?= $_POST["content-post"] ?? "" ?></textarea>
    </div>

    <input class="btn btn-primary w-100" style="background-color: #0d5fd9;" type="submit" name="submit" value="Public Post" />
</form>

<script>
    const btnImage = document.getElementById("btn-image");
    const blockImage = document.getElementById("block-add-image");
    const inputImage = document.getElementById("imgInp");

    btnImage.addEventListener("click", () => {
        blockImage.classList.toggle("active");
        inputImage.required = !inputImage.required;
    })

    // upload file preview
    const loadFile = function(event) {
        const output = document.getElementById('output');
        if (event.target.files[0]) {
            output.src = URL.createObjectURL(event.target.files[0]);
            output.classList.add("border");
        } else {
            output.src = "https://via.placeholder.com/1080x500/CDCDCD/fff?text=Post+Image";
            output.classList.remove("border");
        }
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
    };
</script>