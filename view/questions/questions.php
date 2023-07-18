<?php
if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = "First you need to log in!";
    header("Location: /");
    die();
}

$query = "SELECT questions.*, users.login as login FROM questions LEFT JOIN users ON questions.user_id=users.id";
$res = mysqli_query($link, $query) or die(mysqli_error($link));
for ($questions = []; $row = mysqli_fetch_assoc($res); $questions[] = $row);

$count = count($questions);
for( $i = 0; $i < $count; $i++ ){
    $idQuestion = $questions[$i]["id"];
    $queryCountAnswers = "SELECT COUNT(*) as count FROM answers WHERE question_id=$idQuestion";
    $res = mysqli_fetch_assoc(mysqli_query( $link, $queryCountAnswers ));
    $questions[$i]["count"] = $res["count"];
}

if (!empty($questions)) {
    $content = "";
    foreach ($questions as $question) {
        $date = date_create($question["creationTime"]);
        $hrefViewProfile = "/profile/$question[login]";
        $content .= "
        <div class='card mb-3'>
        <div class='card-body'>
        <div class='d-flex justify-content-between'>
        <p class='card-text'>
        $question[name]
        </p>
        <p class='card-text'>
        customer: <a href='$hrefViewProfile'>$question[login]</a>
        </p>
        </div>
        <div class='d-flex align-content-end justify-content-between'>
        <p class='card-text m-0'><small class='text-body-secondary'>" . date_format($date, "d.m.Y  (H:i)") . "</small></p>
        <p class='card-text m-0'><small class='text-body-secondary'>Number of Answers: " . $question["count"] . "</small></p>
        </div>
        <a href='/questions/$question[id]/$question[slug]' class='btn btn-outline-primary mt-3'>View</a>
        </div>
        </div>
        ";
    }
} else {
    $content = "<h3>There is not a single question on the forum, ask the first one!</h3>";
    $content .= '<a class="btn btn-outline-primary mt-4" href="/create-question">Ask Question!</a>';
}


return [
    "contentTitle" => "Questions",
    "title" => "Questions",
    "content" => $content
];
?>