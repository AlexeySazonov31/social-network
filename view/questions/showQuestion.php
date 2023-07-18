<?php
if( empty($_SESSION["auth"]) or empty($_SESSION["login"]) ){
    $_SESSION["flash"][] = "First you need to log in!";
    header("Location: /");
    die();
}
$idQuestion = $params["idQuestion"];
$slugQuestion = $params["slugQuestion"];

$queryQuestion = "SELECT questions.*, users.login FROM questions LEFT JOIN users ON questions.user_id=users.id WHERE questions.id='$idQuestion'";
$resQuestion = mysqli_query($link, $queryQuestion) or die(mysqli_error($link));
$question = mysqli_fetch_assoc($resQuestion);

if( empty($question) ){
    $_SESSION["flash"][] = "Question don't exist!";
    header("Location: /questions");
    die();
}

$queryCountAnswers = "SELECT COUNT(*) as count FROM answers WHERE question_id=$idQuestion";
$countAnswers = (mysqli_fetch_assoc(mysqli_query( $link, $queryCountAnswers )))["count"];

if( $countAnswers > 0 ){
    $queryGetAnswers = "SELECT answers.*, users.login FROM answers LEFT JOIN users ON answers.user_id=users.id WHERE answers.question_id=$idQuestion ORDER BY id";
    $resAnswers = mysqli_query($link, $queryGetAnswers) or die(mysqli_error($link));
    for( $answers = []; $row = mysqli_fetch_assoc($resAnswers); $answers[] = $row );
}

if( !empty($_POST["submit"]) and !empty($_POST["answer"]) ){
    if( empty($_SESSION["ban"]) ){
        $login = $_SESSION["login"];
        $queryGetId = "SELECT id FROM users WHERE login='$login'";
        $userId = (mysqli_fetch_assoc(mysqli_query($link, $queryGetId)))["id"];
    
        $answer = $_POST["answer"];
    
        $queryInsertAnswer = "INSERT INTO answers SET content='$answer', user_id=$userId, question_id=$idQuestion";
        mysqli_query($link, $queryInsertAnswer) or die(mysqli_error($link));
    
        $_SESSION["flash"][] = "Your response has been successfully published!";
        header("Refresh:0");
        die();
    } else {
        $_SESSION["flash"][] = "Your answer is not published, you are banned. Information about the bath below!";
        header("Location: /profile");
        die();
    }


} elseif ( !empty($_POST["submit"]) and empty($_POST["answer"]) ){
    $_SESSION["flash"][] = "To post an answer, write it yes!";
}



$content = "";
ob_start();
include "forms/show-question-form.php";
$content = ob_get_clean();

return [
    "contentTitle" => "Question: $question[name]",
    "title" => "Questions",
    "content" => $content
];
