<?php 
if( empty($_SESSION["auth"]) ){
    $_SESSION["flash"][] = "You don't have access to this page!";
    header("Location: /");
    die();
} 

$delAnswerID = $params["idAnswer"];

$queryGetCreateAnswerLogin = "SELECT users.login FROM answers LEFT JOIN users ON users.id=answers.user_id WHERE answers.id='$delAnswerID'";
$login = (mysqli_fetch_assoc(mysqli_query($link, $queryGetCreateAnswerLogin)))["login"];

$queryDeleteQuestion = "DELETE FROM answers WHERE id='$delAnswerID'";
if( $_SESSION["login"] === $login or $_SESSION["status"] === "moderator" or $_SESSION["status"] === "admin" ){
    mysqli_query($link, $queryDeleteQuestion);
    $_SESSION["flash"][] = "The answer has been successfully deleted!";
} else {
    $_SESSION["flash"][] = "You don't have access to this action!";
}

header("Location: $_SERVER[HTTP_REFERER]");
die();

?>