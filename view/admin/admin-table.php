<style>
    table td img {
        width: 38px;
        height: 38px;
        object-fit: cover;
        object-position: center;
    }
</style>
<table class='table table-striped table-sm'>
    <thead>
        <tr>
            <th>Login</th>
            <th>Full Name</th>
            <th>BD</th>
            <th>Email</th>
            <th>Created</th>
            <th>Status</th>
            <th>Change</th>
            <th>Del</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><a href="/profile/<?= $user["login"] ?>"><?= $user["login"] ?></td>
                <td>
                    <img src="../../img/avatars/<?= $user["avatar_name"] ?>" alt="av">
                </td>
                <td><?= $user["surname"] . " " . $user["name"] ?></td>
                <td><?= $user["email"] ?></td>
                <td><?= $user["dateCreated"] ?></td>
                <td class="<?= $user["status"] === "admin" ? "text-danger" : "text-secondary" ?>"><?= $user["status"] ?></td>
                <td><a class="text-warning" href="/admin-panel/change-status/<?= $user["login"] ?>">ChangeS</a></td>
                <td><a class="text-danger" href="/admin-panel/delete/<?= $user["login"] ?>">Del</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>