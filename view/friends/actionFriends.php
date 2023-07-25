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
    header("Location: $_SERVER[HTTP_REFERER]");
    die();
}
$login_user_own = $_SESSION["login"];
$id_user_own = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id from users where login='$login_user_own'")))["id"];


$querySearchFriendship = "SELECT * from friends where (user_id_1='$idUser' and user_id_2='$id_user_own') OR (user_id_2='$idUser' and user_id_1='$id_user_own')";
$resSearchFriendship = mysqli_query($link, $querySearchFriendship) or die(mysqli_error($link));
$searchFriendship = mysqli_fetch_assoc($resSearchFriendship);

if ($action === "add") {
    if (!empty($searchFriendship)) {
        $_SESSION["flash"][] = ["status" => false, "text" => "This user your friend or requested friend!"];
        header("Location: $_SERVER[HTTP_REFERER]");
        die();
    }
    $queryInsertFriendRequest = "INSERT into friends set user_id_1='$id_user_own', user_id_2='$idUser'";
    mysqli_query($link, $queryInsertFriendRequest) or die(mysqli_error($link));
    $_SESSION["flash"][] = ["status" => true, "text" => "Friendship successful requested!"];
    header("Location: $_SERVER[HTTP_REFERER]");
    die();
} elseif ($action === "confirm") {
    if(empty($searchFriendship) or $searchFriendship["user_id_1"] === $id_user_own ){
        $_SESSION["flash"][] = ["status" => false, "text" => "Error confirmation friendship!"];
        header("Location: $_SERVER[HTTP_REFERER]");
        die();
    }
    $queryUpdateConfirmFriendRequest = "UPDATE friends set status='1' where user_id_1='$idUser' and user_id_2='$id_user_own'";
    mysqli_query($link, $queryUpdateConfirmFriendRequest) or die(mysqli_error($link));
    $_SESSION["flash"][] = ["status" => true, "text" => "Friendship successful confirmed!"];
    header("Location: $_SERVER[HTTP_REFERER]");
    die();
} elseif ($action === "delete"){
    if(empty($searchFriendship) ){
        $_SESSION["flash"][] = ["status" => false, "text" => "Not found friendship with customer!"];
        header("Location: $_SERVER[HTTP_REFERER]");
        die();
    }
    $queryDeleteFriendShip = "DELETE from friends where id='$searchFriendship[id]'";
    mysqli_query($link, $queryDeleteFriendShip) or die(mysqli_error($link));
    $_SESSION["flash"][] = ["status" => true, "text" => "Friendship successful deleted!"];
    header("Location: $_SERVER[HTTP_REFERER]");
    die();
}



return [
    "contentTitle" => "Friends",
    "title" => "Friends List",
    "content" => $action
];
