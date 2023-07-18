<?php

if( empty($_SESSION["auth"]) or $_SESSION["status"] !== "admin" ){
    $_SESSION["flash"][] = "You don't have access to this page!";
    header("Location: /");
    die();
}

$deleteLogin = $params["deleteLogin"];

$queryDelete = "DELETE FROM users WHERE login='$deleteLogin'";
mysqli_query($link, $queryDelete);

$_SESSION["flash"][] = "The user has been successfully deleted!";
header("Location: /admin-panel");
die();

?>