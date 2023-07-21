<?php 
if( !empty($_SESSION['auth']) ){
    unset($_SESSION["auth"]);
    unset($_SESSION["status"]);
    unset($_SESSION["login"]);
    $_SESSION["flash"][] = ["status" => true, "text" => "You have successfully logged out of your account!"];
    header("Location: /");
    die();
} else {
    $_SESSION["flash"][] = ["status" => false, "text" => "First you need to log in!"];
    header("Location: /");
    die();
}
?>