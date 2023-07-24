<style>
    .avatar_list {
        width: 70px;
        height: 70px;
        margin-top: 8px;
        margin-left: 15px;
        margin-bottom: 7px;
        object-fit: cover;
        border-radius: 50%;
        object-position: center center;
    }
</style>
<div class="card mb-3" style="width: 100%;">
    <div class="row g-0" style="align-items: center;">
        <div class="col-3">
            <img src="../../../img/avatars/<?= $user["avatar_name"] ?>" class="avatar_list" alt="<?= $user["login"] ?>">
        </div>
        <div class="col-6">
            <div class="card-body">
                <h5 class="card-title"><?= $user["name"] ?> <?= $user["surname"] ?? "" ?></h5>
                <p class="card-text"><small class="text-body-secondary"><a href="/profile/<?= $user["login"] ?>" class="link"><?= $user["login"] ?></a></small></p>
            </div>
        </div>
        <div class="col-3 d-flex flex justify-content-center" style="height: 31px; padding-right: 15px;">
            <a type="button" href="/messenger/<?= $user["login"] ?>" class="btn btn-outline-primary w-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                </svg>
            </a>
        </div>
    </div>
</div>