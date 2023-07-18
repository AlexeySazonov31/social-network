<?php 
if( empty($_SESSION["auth"]) ){
    $_SESSION["flash"][] = "You don't have access to this page!";
    header("Location: /");
    die();
} 

$delQuestionID = $params["idQuestion"];

$queryGetCreateQuestionLogin = "SELECT users.login FROM questions LEFT JOIN users ON users.id=questions.user_id WHERE questions.id='$delQuestionID'";
$login = (mysqli_fetch_assoc(mysqli_query($link, $queryGetCreateQuestionLogin)))["login"];

$queryDeleteQuestion = "DELETE FROM questions WHERE id='$delQuestionID'";
if( $_SESSION["login"] === $login or $_SESSION["status"] === "moderator" or $_SESSION["status"] === "admin" ){
    mysqli_query($link, $queryDeleteQuestion);
    $_SESSION["flash"][] = "The question has been successfully deleted!";
} else {
    $_SESSION["flash"][] = "You don't have access to this action!";
}

header("Location: /questions");
die();

?>