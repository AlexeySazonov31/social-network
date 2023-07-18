<?php

if( empty($_SESSION["auth"]) or $_SESSION["status"] !== "admin" ){
    $_SESSION["flash"][] = "You don't have access to this page!";
    header("Location: /");
    die();
}

$queryGetUsers = "SELECT users.*, statuses.status FROM users LEFT JOIN statuses ON users.status_id=statuses.id ORDER BY id";
$res = mysqli_query($link, $queryGetUsers) or die(mysqli_error($link));
for($users = []; $row = mysqli_fetch_assoc($res); $users[] = $row );

$newUsers = [];
foreach( $users as $user ){
        $user["ban_time"] = strtotime($user["ban_time"]) <= time() ? "None" : (strtotime($user["ban_time"]) - time());
        if ($user["ban_time"] !== "None") {
            if ($user["ban_time"] >= 86400) {
                $user["ban_time"] = round($user["ban_time"] / 86400);
                $user["ban_time"] .= " days";
            } elseif ($user["ban_time"] >= 3600) {
                $user["ban_time"] = round($user["ban_time"] / 3600);
                $user["ban_time"] .= " hours";
            } elseif ($user["ban_time"] >= 60) {
                $user["ban_time"] = round($user["ban_time"] / 60);
                $user["ban_time"] .= " min";
            } else {
                $user["ban_time"] .= " sec";
            }
            $user["ban_time"] .= " left";
            $user["Ban Time"] = $user["ban_time"];
        } else {
            $user["Ban Time"] = "none";
        }
    unset($user["ban_time"]);
    $newUsers[] = $user;
}
$users = $newUsers;



ob_start();
include "admin-table.php";
$content = ob_get_clean();

return [
    "contentTitle" => "Admin Panel",
    "title" => "Admin Panel",
    "content" => $content
];
