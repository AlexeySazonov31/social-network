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
        <th>Ban</th>
        <th>Del</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
    <?php foreach( $users as $user ): ?>
        <tr>
        <td><a href="/profile/<?= $user["login"] ?>"><?= $user["login"] ?></td>
        <td><?= $user["surname"] . " " . $user["name"] ?></td>
        <td><?= $user["bd"] ?></td>
        <td><?= $user["email"] ?></td>
        <td><?= $user["dateCreated"] ?></td>
        <td class="<?= $user["status"] === "admin" ? "text-danger" : ($user["status"] === "moderator" ? "text-danger-emphasis" : "text-secondary") ?>"><?= $user["status"] ?></td>
        <td><a class="text-warning" href="/admin-panel/change-status/<?= $user["login"] ?>">ChangeS</a></td>
        <td><?= $user["Ban Time"] ?></td>
        <td><a class="text-danger" href="/admin-panel/delete/<?= $user["login"] ?>">Del</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>