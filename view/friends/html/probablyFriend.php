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
    <div class="row g-0">
        <div class="col-3">
            <img src="../../../img/avatars/<?= $fr["avatar_name"] ?>" class="avatar_list" alt="<?= $fr["login"] ?>">
        </div>
        <div class="col-7">
            <div class="card-body">
                <h5 class="card-title"><?= $fr["name"] ?> <?= $fr["surname"] ?? "" ?></h5>
                <p class="card-text"><small class="text-body-secondary"><?= $fr["login"] ?></small></p>
            </div>
        </div>
        <div class="col-2 d-flex flex-column justify-content-center">
                <a type="button" href="/friends/add/<?= $fr["id"] ?>" class="btn btn-outline-success w-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                </a>
        </div>
    </div>
</div>