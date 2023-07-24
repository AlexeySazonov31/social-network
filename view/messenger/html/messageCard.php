<div class="border rounded px-3 py-2 my-1 <?= $ms["from_user_id"] !== $id_user_own ? "" : "ms-auto" ?>" style="width: fit-content;">
    <div class="d-flex flex-row">
        <div class="">
            <?php if ($ms["from_user_id"] !== $id_user_own) : ?>
                <img class="avatarMessage" src="../../../img/avatars/<?= $user_own["avatar_name"] ?>" alt="av">
            <?php else : ?>
                <img class="avatarMessage" src="../../../img/avatars/<?= $userMessage["avatar_name"] ?>" alt="av">
            <?php endif; ?>
        </div>
        <div class="d-flex flex-column mx-3">
            <div style="font-size: 11px;">
                <?php if ($ms["from_user_id"] !== $id_user_own) : ?>
                    <?= $userMessage["login"] ?>
                <?php else : ?>
                    me
                <?php endif; ?>
            </div>
            <div><?= nl2br($ms["text"]) ?></div>
        </div>
    </div>
</div>