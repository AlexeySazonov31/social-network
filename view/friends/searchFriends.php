<?php 

if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = ["status" => false, "text" => "First you need to log in!"];
    header("Location: /login");
    die();
}

$probablyFriends = getProbableFriends($link);

$content = "";
if( empty($probablyFriends) ){
    $content = "<p>Error search friends</p>";
} else {
    $content .= "<h5>Maybe you know them</h5>";
    foreach($probablyFriends as $fr){
        $statusCard = "search";
        ob_start();
        include "html/friendCard.php";
        $content .= ob_get_clean();
    }
}

ob_start();
include "html/layout.php";
$layout = ob_get_clean();

$layout = str_replace("{{ ContentUsers }}", $content, $layout);

return [
    "contentTitle" => "Search",
    "title" => "Search Friends",
    "content" => $layout
];

// ----------------------------------------------------------------------------------

// users who do not have friendly connections
function getProbableFriends($link){ 
    $login_user_own = $_SESSION["login"];
    $id_user_own = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$login_user_own'")))["id"];


    $queryFriends = "SELECT * FROM friends";
    $resFriendsList = mysqli_query($link, $queryFriends) or die(mysqli_error($link));
    for($friendsList = []; $fr = mysqli_fetch_assoc($resFriendsList); $friendsList[] = $fr);
    $arrIdUsersInFriendsList = [];
    foreach($friendsList as $friend){
        if( $friend["user_id_1"] === $id_user_own or $friend["user_id_2"] === $id_user_own ){
            $arrIdUsersInFriendsList[] = $friend["user_id_1"];
            $arrIdUsersInFriendsList[] = $friend["user_id_2"];
        }
    }
    $arrIdUsersInFriendsList = array_unique($arrIdUsersInFriendsList);

    $strCond = "";
    foreach($arrIdUsersInFriendsList as $idUser ){
        $strCond .= "users.id<>$idUser AND ";
    }
    $strCond = substr($strCond,0,-5);

    
    $queryUsers = "SELECT * FROM users WHERE $strCond LIMIT 10";
    $resQueryUsers = mysqli_query($link, $queryUsers) or die(mysqli_error($link));
    for($users = []; $us = mysqli_fetch_assoc($resQueryUsers); $users[] = $us);
    return $users;
}