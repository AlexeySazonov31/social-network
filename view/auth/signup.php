<?php

if (!empty($_SESSION["auth"])) {
    $_SESSION["flash"][] = "You are already logged in to the system!";
    header("Location: /questions");
    die();
}
if (empty($_POST["submit"])) {
    
} elseif (
    empty($_POST["login"]) or
    empty($_POST["password"]) or
    empty($_POST["confirm"]) or
    empty($_POST["email"]) or
    empty($_POST["name"]) or
    empty($_FILES["avatar"]["name"])
) {
    $_SESSION["flash"][] = "Please fill in all the input fields!";
} elseif( $_POST["confirm"] !== $_POST["password"] ) {
    $_SESSION["flash"][] = "The password does not match the confirmation!";
} elseif ( preg_match('/\w+/', $_POST["login"]) === 0 ) {
    $_SESSION["flash"][] = "Login can contain only Latin letters and numbers!";
} elseif ( !(strlen($_POST["login"]) >= 6) or !(strlen($_POST["login"]) <= 15) ) {
    $_SESSION["flash"][] = "Login length must be > 4 and < 10!";
} elseif ( !(strlen($_POST["password"]) >= 6) or !(strlen($_POST["password"]) <= 20) ) {
    $_SESSION["flash"][] = "Password length must be > 6 and < 12!";
} else {

$targetDir = "img/avatars/";
$fileName = basename($_FILES["avatar"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
$allowTypes = array('jpg','png','jpeg','gif','pdf');

    if(!in_array($fileType, $allowTypes)){
        $_SESSION["flash"][] = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    } elseif (!move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFilePath)) {
        $_SESSION["flash"][] = "Sorry, there was an error uploading your file.";
    } else {

        $login = strtolower($_POST["login"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $email = $_POST["email"];
        $name = $_POST["name"];

        $checkLoginQuery = "SELECT * FROM users WHERE login='$login'";
        $checkLoginUser = mysqli_fetch_assoc(mysqli_query($link, $checkLoginQuery));
    
        if( empty( $checkLoginUser ) ){
    
            $insertQuery = "INSERT INTO users SET login='$login', avatar_name='$fileName', password='$password', email='$email', name='$name', status_id='1'";
            mysqli_query($link, $insertQuery) or die( mysqli_error($link) );
        
            $_SESSION["flash"][] = "Successful Registred!";
            $_SESSION["auth"] = true;
            $_SESSION["login"] = $login;
            $_SESSION["status"] = "user";
    
            header("Location: /profile/$login");
            die();
    
        } else {
            $_SESSION["flash"][] = "This login already exists! Use another.";
        }
    }
}

ob_start();
include "html/signup-form.php";
$content = ob_get_clean();

return [
    "contentTitle" => "Sign Up",
    "title" => "Sign Up",
    "content" => $content
];

?>