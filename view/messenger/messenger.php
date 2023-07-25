<?php

if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = ["status" => false, "text" => "First you need to log in!"];
    header("Location: /login");
    die();
}

$loginUserMessage = $params["login"];
$userMessage = (mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login='$loginUserMessage'")));
if( empty($userMessage) ){
    $_SESSION["flash"][] = ["status" => false, "text" => "Not found this user!"];
    header("Location: /friends");
    die();
}
$idUserMessage = $userMessage["id"];
$login_user_own = $_SESSION["login"];
$id_user_own = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$login_user_own'")))["id"];

if( $loginUserMessage === $login_user_own ){
    $_SESSION["flash"][] = ["status" => false, "text" => "Messenger with yourself is impossible!"];
    header("Location: /profile/$login_user_own");
    die();
}

// if(empty($_POST["submit"])){
// } elseif ( !empty($_POST["mess"]) ){
//     $message = $_POST["mess"];
//     $queryInsertMessage = "INSERT into messages set from_user_id='$id_user_own', to_user_id='$idUserMessage', text='$message'";
//     mysqli_query($link, $queryInsertMessage) or die(mysqli_error($link));
//     header("Refresh:0");
//     die();
// }

$content = "";
ob_start();
include "html/messagePage.php";
$content .= ob_get_clean();
//


return [
    "contentTitle" => "",
    "title" => "Messenger",
    "content" => $content
];