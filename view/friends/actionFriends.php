<?php
if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = ["status" => false, "text" => "First you need to log in!"];
    header("Location: /login");
    die();
}

$action = $params["action"];
$idUser = $params["idUser"];
$querySearchUser = "SELECT * from users where id='$idUser'";
$resSearchUser = mysqli_query($link, $querySearchUser) or die(mysqli_error($link));
$searchUser = mysqli_fetch_assoc($resSearchUser);

if (empty($searchUser)) {
    $_SESSION["flash"][] = ["status" => false, "text" => "User not found!"];
    header("Location: /friends/search");
    die();
}
$login_user_own = $_SESSION["login"];
$id_user_own = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$login_user_own'")))["id"];


$querySearchFriendship = "SELECT * from friends WHERE user_id_1='$idUser' OR user_id_2='$idUser'";
$resSearchFriendship = mysqli_query($link, $querySearchFriendship) or die(mysqli_error($link));
$searchFriendship = mysqli_fetch_assoc($resSearchFriendship);

if ($action === "add") {
    if (!empty($searchFriendship)) {
        $_SESSION["flash"][] = ["status" => false, "text" => "This user your requested friend or friend!"];
        header("Location: /friends");
        die();
    }
    $queryInsertFriendRequest = "INSERT into friends set user_id_1='$id_user_own', user_id_2='$idUser'";
    mysqli_query($link, $queryInsertFriendRequest) or die(mysqli_error($link));
    $_SESSION["flash"][] = ["status" => true, "text" => "Friendship successful requested!"];
    header("Location: /friends");
    die();
}



return [
    "contentTitle" => "Friends",
    "title" => "Friends List",
    "content" => $action
];
