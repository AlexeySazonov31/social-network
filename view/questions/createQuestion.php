<?php
if( empty($_SESSION["auth"]) or empty($_SESSION["login"]) ){
    $_SESSION["flash"][] = "First you need to log in!";
    header("Location: /");
    die();
}
if( !empty($_SESSION["ban"]) ){
    $_SESSION["flash"][] = "You are banned! Detailed information is in your profile (below)!";
    header("Location: /profile");
    die();
}


if( !empty( $_POST["submit"] ) and !empty( $_POST["name"] ) and !empty( $_POST["content"] ) ){
    $nameQuestion = $_POST["name"];
    $contentQuestion = $_POST["content"];

    $slug = str_replace([" ", ",", "?"], ["-", "", ""], $nameQuestion);
    $slug = lcfirst($slug);

    $loginSearch = $_SESSION["login"];
    $queryGetId = "SELECT id FROM users WHERE login='$loginSearch'";
    $userId = (mysqli_fetch_assoc(mysqli_query($link, $queryGetId)))["id"];

    $queryAddQuestion = "INSERT INTO questions SET slug='$slug', name='$nameQuestion', content='$contentQuestion', user_id='$userId'";
    mysqli_query($link, $queryAddQuestion) or die(mysqli_error($link));
    $_SESSION["flash"][] = "You question successful created!";
    header("Location: /questions"); // edit: show this question
    die();
} elseif( !empty($_POST["submit"]) and ( empty($_POST["name"]) or empty($_POST["content"]) ) ){
    $_SESSION["flash"][] = "Please fill in all fields to ask a question!";
}

ob_start();
include "forms/create-question-form.php";
$formCreateQuestion = ob_get_clean();

return [
    "contentTitle" => "Ask Question",
    "title" => "Questions",
    "content" => $formCreateQuestion
];
?>