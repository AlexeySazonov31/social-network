<?php

if( empty($_SESSION["auth"]) or $_SESSION["status"] !== "admin" ){
    $_SESSION["flash"][] = ["status" => false, "text" => "You don't have access to this page!"];
    header("Location: /");
    die();
}

$deleteLogin = $params["deleteLogin"];

$queryDelete = "DELETE FROM users WHERE login='$deleteLogin'";
mysqli_query($link, $queryDelete);

$_SESSION["flash"][] = ["status" => true, "text" => "The user has been successfully deleted!"];
header("Location: /admin-panel");
die();

?>