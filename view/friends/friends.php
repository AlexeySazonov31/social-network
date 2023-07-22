<?php

if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = ["status" => false, "text" => "First you need to log in!"];
    header("Location: /login");
    die();
}

$login_user_own = $_SESSION["login"];
$id_user_own = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$login_user_own'")))["id"];

$queryGetListFriends = 
"SELECT *
FROM friends 
WHERE user_id_1='$id_user_own' OR user_id_2='$id_user_own'";

$resFriends = mysqli_query($link, $queryGetListFriends) or die(mysqli_error($link));
for($friends = []; $fr = mysqli_fetch_assoc($resFriends); $friends[] = $fr);

if(empty($friends)){
    $content = "<p>Do you want to look for your <a href='/friends/search' class='link'>friends</p>";
} else {
    $content = "";
}

$requestFriends = [];
$confirmFriends = [];
$realFriends = [];

$statusCard = "";

// id groups "confirm-request-real"
foreach($friends as $friend){
    if($friend["status"]){
        if( $friend["user_id_1"] === $id_user_own ){
            $realFriends[] = $friend["user_id_2"];
        } else {
            $realFriends[] = $friend["user_id_1"];
        }
    } elseif ( $friend["user_id_1"] === $id_user_own and $friend["user_id_2"] !== $id_user_own ){
        $requestFriends[] = $friend["user_id_2"];
    } elseif ( $friend["user_id_1"] !== $id_user_own and $friend["user_id_2"] === $id_user_own ){
        $confirmFriends[] = $friend["user_id_1"];
    }
}

// content groups "confirm-request-real"
if(!empty($confirmFriends)){
    $content .= "<h5>Need confirmation</h5>";
    foreach($confirmFriends as $id){
        $content .= showFriendCard($id, $link, "confirm");
    }
}
if(!empty($requestFriends)){
    $content .= "<h5>Your friend requests</h5>";
    foreach($requestFriends as $id){
        $content .= showFriendCard($id, $link, "request");
    }
}
if(!empty($realFriends)){
    $content .= "<h5>Your friends (". count($realFriends) .")</h5>";
    foreach($realFriends as $id){
        $content .= showFriendCard($id, $link, "real");
    }
}

ob_start();
include "html/layout.php";
$layout = ob_get_clean();


$layout = str_replace("{{ ContentUsers }}", $content, $layout);


return [
    "contentTitle" => "Friends",
    "title" => "Friends List",
    "content" => $layout
];

function showFriendCard($id, $link, $status){
    $statusCard = $status; // need "friendCard.php" file below
    $queryUser = "SELECT * FROM users WHERE id='$id'";
    $resFr = mysqli_query($link, $queryUser) or die(mysqli_error($link));
    $fr = mysqli_fetch_assoc($resFr); // need "friendCard.php" file below
    ob_start();
    include "html/friendCard.php";
    $card = ob_get_clean();
    return $card;
}