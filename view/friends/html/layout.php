<style>
    .custom-cat-friends {
        z-index: 2;
    }

    @media (max-width: 575px) {
        .custom-friend-group-margin {
            margin-top: 40px;
        }

        .custom-cat-friends {
            width: 100% !important;
        }
    }
</style>
<?php
$curPageName = $_SERVER["REQUEST_URI"];
?>
<div>
    <div class="row">
        <div class="col-sm-4">
            <div class="list-group custom-cat-friends" style="width: 72%;">
                <a href="/friends" class="list-group-item list-group-item-action <?= $curPageName === "/friends" ? "active" : "" ?>" <?= $curPageName === "/friends" ? "aria-current='true'" : "" ?>>
                    All Friends
                </a>
                <a href="/friends/search" class="list-group-item list-group-item-action <?= $curPageName !== "/friends" ? "active" : "" ?>" <?= $curPageName !== "/friends" ? "aria-current='true'" : "" ?>>
                    Search Friends
                </a>
            </div>
        </div>
        <div class="col-sm-8 custom-friend-group-margin">
            {{ ContentUsers }}
        </div>
    </div>