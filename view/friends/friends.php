<?php

if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = ["status" => false, "text" => "First you need to log in!"];
    header("Location: /login");
    die();
}

$login_user_own = $_SESSION["login"];
$id_user_own = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$login_user_own'")))["id"];

$queryGetListFriends = "SELECT * FROM friends WHERE user_id_1='$id_user_own' OR user_id_2='$id_user_own'";
$resFriends = mysqli_query($link, $queryGetListFriends) or die(mysqli_error($link));
for($friends = []; $fr = mysqli_fetch_assoc($resFriends); $friends[] = $fr);

if(empty($friends)){
    $content = "<p>Do you want to look for your <a href='/friends/search' class='link'>friends</p>";
} else {
    $content = count($friends);
}

$curPageName = $_SERVER["REQUEST_URI"];

ob_start();
include "html/layout.php";
$layout = ob_get_clean();


$layout = str_replace("{{ ContentUsers }}", $content, $layout);


return [
    "contentTitle" => "Friends",
    "title" => "Friends List",
    "content" => $layout
];