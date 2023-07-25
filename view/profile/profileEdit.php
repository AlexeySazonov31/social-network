<?php

if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = ["status" => false, "text" => "First you need to log in!"];
    header("Location: /login");
    die();
}

$login = $_SESSION["login"];

// update user data
if (!empty($_POST["submit"])) {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $description = $_POST["description"];

    if (!empty($_FILES["avatar"]["name"])) {
        $targetDir = "img/avatars/";
        $fileName = basename($_FILES["avatar"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

        if (!in_array($fileType, $allowTypes)) {
            $_SESSION["flash"][] = ["status" => false, "text" => "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload."];
        } elseif (!move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFilePath)) {
            $_SESSION["flash"][] = ["status" => false, "text" => "Sorry, there was an error uploading your file."];
        } else {
            $queryUpdate = "UPDATE users SET name='$name', surname='$surname', email='$email', avatar_name='$fileName', description='$description' WHERE login='$login'";
        }
    } else {
        $queryUpdate = "UPDATE users SET name='$name', surname='$surname', email='$email', description='$description' WHERE login='$login'";
    }
    mysqli_query($link, $queryUpdate) or die($link);
    $_SESSION["flash"][] = ["status" => true, "text" => "You data successful updated!"];
    header("Location: /profile/$login");
    die();
}

// get user data
$query = "SELECT name, surname, email, avatar_name FROM users WHERE login='$login'";
$res = mysqli_query($link, $query) or die(mysqli_error($link));
$data = mysqli_fetch_assoc($res);

if ($data["avatar_name"]) {
    $content = '<img class="mb-5 avatar" id="avatar" src="../../img/avatars/' . $data["avatar_name"] . '" alt="profile icon" />';
} else {
    $content = '<img class="mb-5 avatar" id="avatar" src="https://cdn-icons-png.flaticon.com/512/1144/1144709.png" alt="profile icon" />';
}
ob_start();
include "html/edit-form.php";
$formEdit = ob_get_clean();

$content .= $formEdit;

return [
    "contentTitle" => "Profile data change",
    "title" => "Profile",
    "content" => $content
];
