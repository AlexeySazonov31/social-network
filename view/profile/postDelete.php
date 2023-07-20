<?php
$idPost = $params["idPost"];
$creator_login = mysqli_fetch_assoc(mysqli_query($link, "SELECT users.login FROM users LEFT JOIN posts ON posts.creator_user_id=users.id WHERE posts.id='$idPost'"))["login"];


if( $creator_login === $_SESSION["login"] or $_SESSION["status"] === "admin" ){
    $queryDeletePost = "DELETE FROM posts WHERE id='$idPost'";
    mysqli_query($link, $queryDeletePost) or die(mysqli_error($link));
    $_SESSION["flash"][] = "Post deleted!";
    $back = $_SERVER['HTTP_REFERER'];
    header("Location: $back");
    die();
} else {
    $_SESSION["flash"][] = "You don't have access to this action!";
}
?>
