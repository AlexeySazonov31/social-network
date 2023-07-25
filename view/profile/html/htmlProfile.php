<div class="d-flex profilePrimContainer">
    <div class="infoProfile px-3" style="width: 33.3%;">
        <?php if ($data["avatar_name"]) : ?>
            <img class="mb-2 avatar border" src="../../img/avatars/<?= $data["avatar_name"] ?>" alt="profile icon" width="500" height="500" />
        <?php else : ?>
            <img class="mb-2 avatar border" src="https://cdn-icons-png.flaticon.com/512/1144/1144709.png" alt="profile icon" width="500" height="500" />
        <?php endif; ?>

        <h3 class='mt-2 mx-2 fw-normal'><?= ucfirst($data["name"]) ?> <?= ucfirst($data["surname"]) ?? "" ?></h3>
        <h6 class='mb-2 mt-2 mx-2 fw-normal d-flex justify-content-between'><b>Login: </b><span><?= $data["login"] ?></span></h6>
        <h6 class='mb-2 mx-2 fw-normal d-flex justify-content-between'><b>Email: </b><span><?= $data["email"] ?></span></h6>
        <h6 class='mb-3 fw-normal mx-2 d-flex justify-content-between'><b>Friends: </b><span><?= $countFriends["count"] ?></span></h6>

        <?php if (!empty($data["description"])) : ?>
            <h6 class='mb-3 mx-2 fw-normal'><b>Description:</b> <br><?= nl2br($data["description"]) ?></h6>
        <?php endif; ?>

        <?php if (!$own) : ?>
            <div class="d-flex flex-column mx-2">
            <?php if (empty($friendship)) : ?>
                <a href='/friends/add/<?= $idProfileView ?>' class="btn btn-outline-success">ADD FRIEND</a>
            <?php elseif ($friendship["status"]) : ?>
                <span class="badge text-bg-success mb-3 px-3">Your friend</span><br>
                <!-- // message -->
                <a href='/messenger/<?= $loginProfileView ?>' class='btn btn-outline-primary my-2'>message</a>
                <!-- // --------->
                <a href='/friends/delete/<?= $idProfileView ?>' class='btn btn-outline-danger'>delete friend</a>
            <?php elseif ($friendship["user_id_1"] === $id_user_own) : ?>
                <span class="badge text-bg-primary mb-3 px-3">Friendship requested</span>
                <br>
                <br>
                <a href='/friends/delete/<?= $idProfileView ?>' class='btn btn-outline-danger'>delete request</a>
            <?php else : ?>
                <a href='/friends/confirm/<?= $idProfileView ?>' class='btn btn-outline-success'>confirm friendship</a>
                <a href='/friends/delete/<?= $idProfileView ?>' class='btn btn-outline-danger my-2'>refuse</a>
            <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        if ($own) {
            ob_start();
            include "buttons-edit-pass-delete.php";
            $buttonsOwn = ob_get_clean();
            echo $buttonsOwn;
        }
        ?>
    </div>
    <div class='postsProfile px-3' style='width: 66.7%;'>
        <?= $createPostForm ?>

        <?php if (!empty($posts)) : ?>
            <h3><?= count($posts) ?> Posts</h3>
            <?php foreach ($posts as $post) : ?>
                <?php ob_start();
                include "post.php";
                $post = ob_get_clean(); ?>
                <?= $post ?>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>