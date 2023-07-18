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
    empty($_POST["surname"]) or
    empty($_POST["bd"])
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
} elseif( empty($_FILES["file"]["name"]) ) {
    $_SESSION["flash"][] = "Please select avatar image!";
    var_dump($_FILES);
} else {

    $login = $_POST["login"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $bd = $_POST["bd"];
    $banTime = date( 'Y-m-d H:i:s', time() );

    $checkLoginQuery = "SELECT * FROM users WHERE login='$login'";
    $checkLoginUser = mysqli_fetch_assoc(mysqli_query($link, $checkLoginQuery));

    if( empty( $checkLoginUser ) ){

        var_dump($checkLoginUser);
        var_dump($fileName);

        $insertQuery = "INSERT INTO users SET login='$login', password='$password', email='$email', name='$name', surname='$surname', bd='$bd', status_id='1', ban_time='$banTime'";
        mysqli_query($link, $insertQuery) or die( mysqli_error($link) );
    
        $_SESSION["flash"][] = "Successful Registred!";
        $_SESSION["auth"] = true;
        $_SESSION["login"] = $login;
        $_SESSION["ban"] = null;
        $_SESSION["status"] = "user";

        header("Location: /questions");
        die();

    } else {
        $_SESSION["flash"][] = "This login already exists! Use another.";
    }

    // $targetDir = "uploads/";
    // $fileName = basename($_FILES["file"]["name"]);
    // $targetFilePath =  $targetDir . $fileName;
    // $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    // $allowTypes = array('jpg','png','jpeg','gif','pdf');
    // if(in_array($fileType, $allowTypes)){
    //     if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath) ){
    //         // --------------------


    //         // --------------------

    //     } else {
    //         $_SESSION["flash"][] = "Sorry, there was an error uploading your file.";
    //     }
    // } else {
    //     $_SESSION["flash"][] = "Only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload!";
    // }
}

ob_start();
include "forms/signup-form.php";
$content = ob_get_clean();

return [
    "contentTitle" => "Sign Up",
    "title" => "Sign Up",
    "content" => $content
];
?>