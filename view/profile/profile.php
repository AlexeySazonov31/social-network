<?php 

if( empty($_SESSION["auth"]) or empty($_SESSION["login"]) ){
    $_SESSION["flash"][] = "First you need to log in!";
    header("Location: /");
    die();
}

$loginProfile = $params["login"];
$own = $params["login"] === $_SESSION["login"] ? true : false;

$query = "SELECT name, surname, login, email, ban_time FROM users WHERE login='$loginProfile'";
$res = mysqli_query($link, $query) or die(mysqli_error($link));
$data = mysqli_fetch_assoc($res);

$data["ban_time"] = strtotime($data["ban_time"]) <= time() ? "None" : (strtotime($data["ban_time"]) - time());

if( $data["ban_time"] !== "None" ){
    if( $data["ban_time"] >= 86400 ){
        $data["ban_time"] = round($data["ban_time"] / 86400);
        $data["ban_time"] .= " days";
    } elseif ( $data["ban_time"] >= 3600 ){
        $data["ban_time"] = round($data["ban_time"] / 3600);
        $data["ban_time"] .= " hours";
    } elseif ( $data["ban_time"] >= 60 ){
        $data["ban_time"] = round($data["ban_time"] / 60);
        $data["ban_time"] .= " min";
    } else {
        $data["ban_time"] .= " sec";
    }
    $data["ban_time"] .= " left";
    $data["Ban Time"] = $data["ban_time"];
}
unset($data["ban_time"]);



$content = '<img class="w-25 mb-5" src="https://cdn-icons-png.flaticon.com/512/1144/1144709.png" alt="profile icon" />';

foreach( $data as $key => $value ){
    $content .= "<h6 class='mt-4 fw-normal'><b>" . ucfirst($key) . ":</b> $value<h6>";
}


if( $own ){
    $content .= '<div class="mt-5">';
    $content .= '<a class="btn btn-warning" href="/profile/edit">Edit Account Data</a>';
    $content .= '<a class="btn btn-warning mx-2" href="/profile/change-pass">Change Password</a>';
    $content .= '<a class="btn btn-danger" href="/profile/delete">Delete Account</a>';
    $content .= '</div>';
} else {
    if ($_SESSION["status"] === "moderator" or $_SESSION["status"] === "admin") {

        if (!empty($_POST["submitBan"]) and !empty($_POST["confirm"]) and $_POST["confirm"] === "confirm") {
    
            $time = $_POST["time-ban"];
            if ($time === "0") {
                $time = date('Y-m-d H:i:s', time());
                $message = "Remove the ban from the user!";
            } else {
                $time += time();
                $time = date('Y-m-d H:i:s', $time);
                $message = "The user is banned!";
            }
    
            $queryUpdateBan = "UPDATE users SET ban_time='$time' WHERE login='$loginProfile'";
            mysqli_query($link, $queryUpdateBan) or die(mysqli_error($link));
    
            $_SESSION["flash"][] = $message;
            header("Refresh:0");
            die();
        }
    
        // form include
        ob_start();
        include "forms/ban-form.php";
        $banForm = ob_get_clean();
        $content .= $banForm;
    } else {
        if (!empty($_POST["submitBan"])) {
            $_SESSION["flash"][] = "You don't have access for this action!";
            header("Refresh:0");
            die();
        }
    }
}

return [
    "contentTitle" => "Profile",
    "title" => "Profile",
    "content" => $content
];
?>