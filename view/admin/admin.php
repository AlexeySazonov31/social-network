<?php

if( empty($_SESSION["auth"]) or $_SESSION["status"] !== "admin" ){
    $_SESSION["flash"][] = "You don't have access to this page!";
    header("Location: /");
    die();
}

$queryGetUsers = "SELECT users.*, statuses.status FROM users LEFT JOIN statuses ON users.status_id=statuses.id ORDER BY id";
$res = mysqli_query($link, $queryGetUsers) or die(mysqli_error($link));
for($users = []; $row = mysqli_fetch_assoc($res); $users[] = $row );

ob_start();
include "admin-table.php";
$content = ob_get_clean();

return [
    "contentTitle" => "Admin Panel",
    "title" => "Admin Panel",
    "content" => $content
];
