<?php 

if( empty($_SESSION["auth"]) or empty($_SESSION["login"]) ){
    $_SESSION["flash"][] = "First you need to log in!";
    header("Location: /");
    die();
}

$login = $_SESSION["login"];

// update user data
if( !empty( $_POST["submit"] ) ){
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];

    $queryUpdate = "UPDATE users SET name='$name', surname='$surname', email='$email' WHERE login='$login'";
    mysqli_query($link, $queryUpdate) or die($link);
    $_SESSION["flash"][] = "You data successful updated!";
}

// get user data
$query = "SELECT name, surname, email FROM users WHERE login='$login'";
$res = mysqli_query($link, $query) or die(mysqli_error($link));
$data = mysqli_fetch_assoc($res);

$content = '<img class="w-25 mb-5" src="https://cdn-icons-png.flaticon.com/512/1144/1144709.png" alt="profile icon" />';

ob_start();
include "forms/edit-form.php";
$formEdit = ob_get_clean();

$content .= $formEdit;

return [
    "contentTitle" => "Profile data change",
    "title" => "Profile",
    "content" => $content
];
?>