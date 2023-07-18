<?php
if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = "First you need to log in!";
    header("Location: /");
    die();
}

$login = $_SESSION["login"];

if ( !empty($_POST["submit"]) and !empty($_POST["password"])) {
    $query = "SELECT * FROM users WHERE login='$login'";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $user = mysqli_fetch_assoc($res);

    $hash = $user["password"];
    $password = $_POST["password"];

    if (password_verify($password, $hash)) {
        $query = "DELETE FROM users WHERE login='$login'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION["flash"][] = "Your account deleted successful!";
        header("Location: /logout");
        die();
    } else {
        $_SESSION["flash"][] = "The password was entered incorrectly!";
    }
} elseif ( !empty($_POST["submit"]) and empty($_POST["password"])) {
    $_SESSION["flash"][] = "Please enter your password to delete account!";
}

ob_start();
include "forms/delete-form.php";
$content = ob_get_clean();

return [
    "contentTitle" => "Profile delete",
    "title" => "Delete Account",
    "content" => $content
];
