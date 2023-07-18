<?php 

if( empty($_SESSION["auth"]) or $_SESSION["status"] !== "admin" ){
    $_SESSION["flash"][] = "You don't have access to this page!";
    header("Location: /");
    die();
}

$changeLogin = $params["changeLogin"];

$queryGetStatusId = "SELECT status_id FROM users WHERE login='$changeLogin'";
$statusId = mysqli_fetch_assoc(mysqli_query($link, $queryGetStatusId))["status_id"];

$newStatusId = ( $statusId === "1" ? "2" : "1" );

$queryUpdateStatusId = "UPDATE users SET status_id='$newStatusId' WHERE login='$changeLogin'";
mysqli_query($link, $queryUpdateStatusId);

$_SESSION["flash"][] = "The user-status has been successfully changed!";
header("Location: /admin-panel");
die();

?>