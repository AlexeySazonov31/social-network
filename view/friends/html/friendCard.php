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
            <img src="../../../img/avatars/<?= $fr["avatar_name"] ?>" class="avatar_list" alt="<?= $fr["login"] ?>">
        </div>
        <div class="col-6">
            <div class="card-body">
                <h5 class="card-title"><?= $fr["name"] ?> <?= $fr["surname"] ?? "" ?></h5>
                <p class="card-text"><small class="text-body-secondary"><?= $fr["login"] ?></small></p>
            </div>
        </div>
        <div class="col-3 d-flex flex justify-content-center" style="height: 31px; padding-right: 15px;">
            <?php if ($statusCard === "search") : ?>
                <a type="button" href="/friends/add/<?= $fr["id"] ?>" class="btn btn-outline-success w-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                </a>
            <?php elseif ($statusCard === "confirm") : ?>
                <a type="button" href="/friends/confirm/<?= $fr["id"] ?>" class="btn btn-outline-success w-50 mx-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                    </svg>
                </a>
                <a type="button" href="/friends/delete/<?= $fr["id"] ?>" class="btn btn-outline-danger w-50 mx-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            <?php elseif ($statusCard === "request") : ?>
                <a type="button" href="/friends/delete/<?= $fr["id"] ?>" class="btn btn-outline-danger w-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            <?php elseif ($statusCard === "real") : ?>
                <a type="button" href="/friends/delete/<?= $fr["id"] ?>" class="btn btn-outline-danger w-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>