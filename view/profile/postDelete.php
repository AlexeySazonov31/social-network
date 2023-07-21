<?php
$idPost = $params["idPost"];
$back = $_SERVER['HTTP_REFERER'];
$loginProfileView = str_replace('/', '', (strrchr($back, "/")));

$searchPostQuery = "SELECT * FROM posts WHERE id='$idPost'";
$resSearchPost = mysqli_query($link, $searchPostQuery) or die(mysqli_error($link));
$searchPost = mysqli_fetch_assoc($resSearchPost);

function deleteUser($link, $idPost, $back){
    $queryDeletePost = "DELETE FROM posts WHERE id='$idPost'";
    mysqli_query($link, $queryDeletePost) or die(mysqli_error($link));
    $_SESSION["flash"][] = ["status" => true, "text" => "Post deleted!"];
    header("Location: $back");
    die();
}

if (empty($searchPost)) {
    // not exist post
    $_SESSION["flash"][] = ["status" => false, "text" => "Post not found!"];
    header("Location: $back");
    die();
} elseif ($_SESSION["status"] === "admin" or $_SESSION["login"] === $loginProfileView) {
    // admin or own can delete post
    deleteUser($link, $idPost, $back);
} else {
    $resCreator = mysqli_query($link, "SELECT users.login FROM users LEFT JOIN posts ON posts.creator_user_id=users.id WHERE posts.id='$idPost'");
    $creator = mysqli_fetch_assoc($resCreator);
    if ($creator["login"] === $_SESSION["login"]) {
        // own post on another profile
        deleteUser($link, $idPost, $back);
    } else {
        // don't have access

        $_SESSION["flash"][] = ["status" => false, "text" => "You don't have access to this action!"];
        header("Location: $back");
        die();
    }
}
?>
