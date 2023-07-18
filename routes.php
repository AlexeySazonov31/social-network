<?php
session_start();

require "configDB.php";

$uri = strtolower($_SERVER["REQUEST_URI"]);

$routeHome = "^/$";

$routeLogin = "^/login$";
$routeSignUp = "^/signup$";
$routeLogout = "^/logout$";


$routeProfile = "^/profile/(?<login>[a-z0-9_-]+)$";
$routeProfileEdit = "^/profile/edit$";
$routeProfileChangePass = "^/profile/change-pass$";
$routeProfileDelete = "^/profile/delete$";

$routeCreateQuestion = "^/create-question$";
$routeShowSetQuestions = "^/questions$";
$routeShowQuestion = "^/questions/(?<idQuestion>[a-z0-9_-]+)/(?<slugQuestion>[a-z0-9_-]+)$";
$routeDeleteQuestion = "^/delete/questions/(?<idQuestion>[a-z0-9_-]+)$";
$routeDeleteAnswer = "^/delete/answers/(?<idAnswer>[a-z0-9_-]+)$";

$routeAdminPanel = "^/admin-panel$";
$routeAdminPanelDelete = "^/admin-panel/delete/(?<deleteLogin>[a-z0-9_-]+)$";
$routeAdminPanelChange = "^/admin-panel/change-status/(?<changeLogin>[a-z0-9_-]+)$";

if( preg_match( "#$routeHome#", $uri ) ){
    $page = include "view/home/home.php";
    $pageName = "home";
} elseif (preg_match("#$routeLogin#", $uri )){
    $page = include "view/auth/login.php";
    $pageName = "login";
} elseif (preg_match("#$routeSignUp#", $uri )){
    $page = include "view/auth/signup.php";
    $pageName = "signup";
} elseif (preg_match("#$routeLogout#", $uri )){
    $page = include "view/auth/logout.php";
} elseif (preg_match("#$routeProfile#", $uri, $params )){
    $page = include "view/profile/profile.php";
    $pageName = "profile";
} elseif (preg_match("#$routeProfileEdit#", $uri )){
    $page = include "view/profile/profileEdit.php";
} elseif (preg_match("#$routeProfileChangePass#", $uri )){
    $page = include "view/profile/changePassword.php";
} elseif (preg_match("#$routeProfileDelete#", $uri )){
    $page = include "view/profile/delete.php";
} elseif (preg_match("#$routeCreateQuestion#", $uri )){
    $page = include "view/questions/createQuestion.php";
} elseif (preg_match("#$routeShowSetQuestions#", $uri )){
    $page = include "view/questions/questions.php";
} elseif (preg_match("#$routeShowQuestion#", $uri, $params )){
    $page = include "view/questions/showQuestion.php";
} elseif (preg_match("#$routeDeleteQuestion#", $uri, $params )){
    $page = include "view/questions/deleteQuestion.php";
} elseif (preg_match("#$routeDeleteAnswer#", $uri, $params )){
    $page = include "view/questions/deleteAnswer.php";
} elseif (preg_match("#$routeAdminPanel#", $uri )){
    $page = include "view/admin/admin.php";
} elseif (preg_match("#$routeAdminPanelDelete#", $uri, $params )){
    $page = include "view/admin/admin-delete.php";
} elseif (preg_match("#$routeAdminPanelChange#", $uri, $params )){
    $page = include "view/admin/admin-change.php";
} else {
    $page = [
        "contentTitle" => "Error:",
        "title" => "Error",
        "content" => "Page not found"
    ];
}

$flash = "";
if( !empty($_SESSION["flash"]) ){
    foreach( $_SESSION["flash"] as $message ){
        $flash .= '<div class="alert alert-success mt-2 px-4" role="alert">' . $message . '</div>';
    }
    unset($_SESSION["flash"]);
}

ob_start();
include "layout.php";
$layout = ob_get_clean();

$layout = str_replace("{{ flash }}", $flash, $layout);
$layout = str_replace("{{ title }}", $page["title"], $layout);
$layout = str_replace("{{ content }}", $page["content"], $layout);
$layout = str_replace("{{ contentTitle }}", $page["contentTitle"], $layout);

echo $layout;
?>