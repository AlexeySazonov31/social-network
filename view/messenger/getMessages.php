<?php 
if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = ["status" => false, "text" => "First you need to log in!"];
    header("Location: /login");
    die();
}

$login_user_own = $_SESSION["login"];
$user_own = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login='$login_user_own'"));
$id_user_own = $user_own["id"];

if( empty($_POST["confirm"]) or empty($_POST["idUserMessage"]) ){
    header("Location: /error");
    die();
} else {
    $idUserMessage = $_POST["idUserMessage"];
    $userMessage = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE id='$idUserMessage'"));

    $queryGetListMessages = 
    "SELECT * 
    from messages 
    where 
    (from_user_id='$id_user_own' and to_user_id='$idUserMessage') 
    or
    (from_user_id='$idUserMessage' and to_user_id='$id_user_own')";
    
    $resMessages = mysqli_query($link, $queryGetListMessages) or die(mysqli_error($link));
    for($messages = []; $ms = mysqli_fetch_assoc($resMessages); $messages[] = $ms);

    if( empty($userMessage) or empty($messages) ){
        header("Location: /errorr");
        die();
    }

    $content = "";
    foreach($messages as $ms){
        $end = false;
        if( $ms["id"] === $messages[(count($messages))-1]["id"] ){
            $end = true;
        }
        ob_start();
        include "html/messageCard.php";
        $content .= ob_get_clean();
    }
    
}

echo json_encode($content);
?>