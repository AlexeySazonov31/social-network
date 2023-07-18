<?php 

$login = $_SESSION["login"];

    if( 
    !empty($_POST["submit"]) and
    !empty($_POST["password"]) and
    !empty($_POST["new_password"]) and
    !empty($_POST["new_password_confirm"]) and
    $_POST["new_password"] === $_POST["new_password_confirm"]
    ){
        $query = "SELECT * FROM users WHERE login='$login'";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        $user = mysqli_fetch_assoc($res);

        $hash = $user["password"];
        $oldPassword = $_POST["password"];
        $newPassword = $_POST["new_password"];

        if(password_verify( $oldPassword, $hash )){
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            $query = "UPDATE users SET password='$newPasswordHash' WHERE login='$login'";
            mysqli_query( $link, $query ) or die( mysqli_error($link) );
            $_SESSION["flash"][] = "Password successful updated!";
            header( "Location: /profile" );
            die();
        } else {
            $_SESSION["flash"][] = "The old password was entered incorrectly!";
        }
    } elseif (
        !empty($_POST["submit"]) and (
        empty($_POST["password"]) or
        empty($_POST["new_password"]) or
        empty($_POST["new_password_confirm"])
        )
    ) {
        $_SESSION["flash"][] = "Please enter all inputs!";
    } elseif ( !empty($_POST["submit"]) and $_POST["new_password"] !== $_POST["new_password_confirm"]){
        $_SESSION["flash"][] = "The password does not match the confirmation!";
    }

    ob_start();
    include "forms/change-pass-form.php";
    $content = ob_get_clean();

    return [
        "contentTitle" => "Change Password",
        "title" => "Change password",
        "content" => $content
    ]
?>