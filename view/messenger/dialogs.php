<?php

if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = ["status" => false, "text" => "First you need to log in!"];
    header("Location: /login");
    die();
}


$login_user_own = $_SESSION["login"];
$id_user_own = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$login_user_own'")))["id"];

$queryGetListMessages = 
"SELECT * 
from messages 
where from_user_id='$id_user_own' or to_user_id='$id_user_own'";

$resMessages = mysqli_query($link, $queryGetListMessages) or die(mysqli_error($link));
for($messages = []; $ms = mysqli_fetch_assoc($resMessages); $messages[] = $ms);

$content = "";
if(empty($messages)){
    $content = "<p>Do you want message someone of your <a href='/friends'>friends</a>?</p>";
} else {

    $arrIdUserDialogs = [];
    foreach( $messages as $ms ){
        $arrIdUserDialogs[] = $ms["from_user_id"];
        $arrIdUserDialogs[] = $ms["to_user_id"];        
    }
    $arrIdUserDialogs = array_diff(array_unique($arrIdUserDialogs), [$id_user_own]);

    foreach($arrIdUserDialogs as $idUser){

        $queryUser = "SELECT * from users where id='$idUser'";
        $resUser = mysqli_query($link, $queryUser) or die(mysqli_error($link));
        $user = mysqli_fetch_assoc($resUser);

        ob_start();
        include "html/messageUserCard.php";
        $content .= ob_get_clean();
    }
}







ob_start();
include "html/layout.php";
$layout = ob_get_clean();


return [
    "contentTitle" => "Messenger List",
    "title" => "Messenger",
    "content" => $content
];