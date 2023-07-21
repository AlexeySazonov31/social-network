<?php
$creatorQuery = "SELECT users.login, users.id FROM users LEFT JOIN posts ON posts.creator_user_id=users.id WHERE posts.id='$post[id]'";
$resCreator = mysqli_query($link, $creatorQuery);
$creator = mysqli_fetch_assoc($resCreator);
if (!empty($creator)) {
    $creatorLogin = $creator["login"];
    $creatorId = $creator["id"];
} else {
    $creatorLogin = "deleted user";
    $creatorId = null;
}
?>
<div class="card mb-4">
    <?php if (isset($post["img_name"])) : ?>
        <img src="../../../img/posts/<?= $post["img_name"] ?>" class="card-img-top" alt="image post" style="border-bottom: 1px solid rgba(0, 0, 0, 0.175);">
    <?php endif; ?>
    <div class="card-body">
        <p class="card-text">
            <?= nl2br($post["content"]) ?>
        </p>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <p class="card-text p-0 m-0 pt-1">
            <small class="text-body-secondary">
                <?php if ($post["creator_user_id"] === $id_user_own) : ?>
                    Your post
                <?php elseif ($post["creator_user_id"] === $idProfileView or $creatorId === null) : ?>
                    <?= $creatorLogin ?>
                <?php else : ?>
                    <a class="link-primary" href="/profile/<?= $creatorLogin ?>"><?= $creatorLogin ?></a>
                <?php endif; ?>
                :
                <?= date_format(date_create($post["creation_time"]), "Y.m.d H:i") ?>
            </small>
        </p>
        <?php if ($loginProfileView === $_SESSION["login"] or $creatorId === $id_user_own or $_SESSION["status"] === "admin") : ?>
            <a href="/profile/post-delete/<?= $post["id"] ?>" class="card-link link-danger">delete</a>
        <?php endif; ?>
    </div>
</div>