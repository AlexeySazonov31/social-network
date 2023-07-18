<?php

if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = "First you need to log in!";
    header("Location: /");
    die();
}

$loginProfile = $params["login"];
$own = $params["login"] === $_SESSION["login"] ? true : false;

$query = "SELECT name, surname, login, email, avatar_name FROM users WHERE login='$loginProfile'";
$res = mysqli_query($link, $query) or die(mysqli_error($link));
$data = mysqli_fetch_assoc($res);


if ($data["avatar_name"]) {
    $content = '<img class="mb-5 avatar" src="../../uploads/' . $data["avatar_name"] . '" alt="profile icon" />';
} else {
    $content = '<img class="mb-5 avatar" src="https://cdn-icons-png.flaticon.com/512/1144/1144709.png" alt="profile icon" />';
}

foreach ($data as $key => $value) {
    if( $value and $key !== "avatar_name" ){
        $content .= "<h6 class='mt-4 fw-normal'><b>" . ucfirst($key) . ":</b> $value<h6>";
    }
}


if ($own) {
    $content .= '<div class="mt-5">';
    $content .= '<a class="btn btn-warning" href="/profile/edit">Edit Account Data</a>';
    $content .= '<a class="btn btn-warning mx-2" href="/profile/change-pass">Change Password</a>';
    $content .= '<a class="btn btn-danger" href="/profile/delete">Delete Account</a>';
    $content .= '</div>';
}

return [
    "contentTitle" => "Profile",
    "title" => "Profile",
    "content" => $content
];
?>