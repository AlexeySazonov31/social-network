<?php
if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    header("HTTP/1.0 401 First you need to log in");
    die();
}

if (
    empty($_POST["confirm"]) or
    empty($_POST["idUserMessage"]) or
    empty($_POST["message"]) or
    empty($_POST["loginUserMessage"])
) {
    header("HTTP/1.0 404 Error data upload");
    die();
}

$loginUserMessage = $_POST["loginUserMessage"];
$idUserMessage = $_POST["idUserMessage"];
$message = $_POST["message"];

$login_user_own = $_SESSION["login"];
$id_user_own = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$login_user_own'")))["id"];

if ($loginUserMessage === $login_user_own) {
    header("HTTP/1.0 404 Messenger with yourself is impossible");
    die();
}


$queryInsertMessage = "INSERT into messages set from_user_id='$id_user_own', to_user_id='$idUserMessage', text='$message'";
mysqli_query($link, $queryInsertMessage) or die(mysqli_error($link));

echo json_encode( "success" );