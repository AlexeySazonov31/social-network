<?php

if( !empty($_SESSION["auth"])  ){
    $_SESSION["flash"][] = ["status" => true, "text" => "You are already logged in to the system!"];
    header("Location: /profile");
    die();
}

if (empty($_POST["submit"])) {
    
} elseif (
    empty($_POST["login"]) or
    empty($_POST["password"])
) {
    $_SESSION["flash"][] = ["status" => false, "text" => "Please enter login and password!"];
} else {
    $login = $_POST["login"];
    $searchLoginQuery = "SELECT users.*, statuses.status as status FROM users LEFT JOIN statuses ON users.status_id=statuses.id WHERE login='$login'";
    $res = mysqli_query( $link, $searchLoginQuery ) or die(mysqli_error($link));
    $user = mysqli_fetch_assoc($res);

    if(!empty($user)){
        $hash = $user["password"];
        if( password_verify($_POST["password"], $hash) ){
            $_SESSION["auth"] = true;
            $_SESSION["login"] = $user["login"];
            $_SESSION["status"] = $user["status"];
            $_SESSION["flash"][] = ["status" => true, "text" => "You have successfully logged in!"];
            header("Location: /");
            die();
        } else {
            $_SESSION["flash"][] = ["status" => false, "text" => "Login or password entered incorrectly. Please try again!"];
        }
    } else {
        $_SESSION["flash"][] = ["status" => false, "text" => "Login or password entered incorrectly. Please try again!"];
    }
}

ob_start();
include "html/login-form.php";
$content = ob_get_clean();

return [
    "contentTitle" => "Login",
    "title" => "Sign Up",
    "content" => $content
]
?>
