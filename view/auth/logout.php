<?php 
if( !empty($_SESSION['auth']) ){
    unset($_SESSION["auth"]);
    unset($_SESSION["status"]);
    unset($_SESSION["login"]);
    $_SESSION["flash"][] = "You have successfully logged out of your account!";
    header("Location: /");
    die();
} else {
    $_SESSION["flash"][] = "First you need to log in!";
    header("Location: /");
    die();
}
?>