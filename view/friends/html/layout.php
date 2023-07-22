<div>
    <div class="row">
        <div class="col-sm-4">
            <div class="list-group" style="width: 72%;">
                <a href="/friends" class="list-group-item list-group-item-action <?= $curPageName === "/friends" ? "active" : "" ?>" <?= $curPageName === "/friends" ? "aria-current='true'" : "" ?>>
                    All Friends
                </a>
                <a href="/friends/search" class="list-group-item list-group-item-action <?= $curPageName !== "/friends" ? "active" : "" ?>" <?= $curPageName !== "/friends" ? "aria-current='true'" : "" ?>>
                    Search Friends
                </a>
            </div>
        </div>
        <div class="col-sm-8">
            {{ ContentUsers }}
        </div>
    </div>