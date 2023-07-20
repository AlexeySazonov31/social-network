<?php 

$creatorLoginQuery = "SELECT users.login FROM users LEFT JOIN posts ON posts.creator_user_id=users.id WHERE posts.id='$post[id]'";
$creatorLogin = mysqli_fetch_assoc(mysqli_query($link, $creatorLoginQuery))["login"];
?>
<div class="card mb-4">
    <?php if (isset($post["img_name"])) : ?>
        <img src="../../../img/posts/<?= $post["img_name"] ?>" class="card-img-top" alt="image post" style="border-bottom: 1px solid rgba(0, 0, 0, 0.175);">
    <?php endif; ?>
    <div class="card-body">
        <p class="card-text">
            <?= $post["content"] ?>
        </p>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <p class="card-text p-0 m-0 pt-1">
            <small class="text-body-secondary">
                <?php if ($post["creator_user_id"] === $id_user) : ?>
                    Your post:
                <?php elseif($post["login"] === $loginProfile ): ?>
                    <?= $creatorLogin ?>:
                <?php else: ?>
                <a class="link-primary" href="/profile/<?= $creatorLogin ?>"><?= $creatorLogin ?></a>:
<?php endif; ?>
                <?= date_format(date_create($post["creation_time"]), "Y.m.d H:i") ?>
            </small>
        </p>
        <?php if ($id_user === $post["creator_user_id"] or $_SESSION["status"] === "admin") : ?>
            <a href="/profile/post-delete/<?= $post["id"] ?>" class="card-link link-danger">delete</a>
        <?php endif; ?>
    </div>
</div>