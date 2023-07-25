<style>
    .infoProfile {
        position: sticky;
        top: 30px;
        height: fit-content;
    }

    @media (max-width: 576px) {
        .profilePrimContainer {
            flex-direction: column;
        }

        .infoProfile {
            position: static;
            width: 100% !important;
            margin-bottom: 50px;
        }

        .postsProfile {
            width: 100% !important;
        }

        .create-post-h {
            position: static !important;
        }
    }
</style>
<?php

if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = ["status" => false, "text" => "First you need to log in!"];
    header("Location: /login");
    die();
}

$loginProfileView = $params["login"];

$query = "SELECT name, surname, login, email, avatar_name, description FROM users WHERE login='$loginProfileView'";
$res = mysqli_query($link, $query) or die(mysqli_error($link));
$data = mysqli_fetch_assoc($res);

if (empty($data)) {
    $error = "<h3>User not found<h3>";
    return [
        "contentTitle" => "<span class='text-danger'>Error:</span>",
        "title" => "Profile",
        "content" => $error
    ];
}

$idProfileView = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$loginProfileView'")))["id"];
$login_user_own = $_SESSION["login"];
$id_user_own = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$login_user_own'")))["id"];
$own = $params["login"] === $_SESSION["login"] ? true : false;

$queryCountFriends = "SELECT count(*) as count 
from friends 
where
user_id_1='$id_user_own'
or
user_id_2='$id_user_own'";
$resCountFriends = mysqli_query($link, $queryCountFriends) or die(mysqli_error($link));
$countFriends = mysqli_fetch_assoc($resCountFriends);

if (!$own) {
    $querySearchFriendShip = "SELECT * 
    from friends 
    WHERE 
    (user_id_1='$id_user_own' and user_id_2='$idProfileView')
    or
    (user_id_2='$id_user_own' and user_id_1='$idProfileView')";
    $resFriendship = mysqli_query($link, $querySearchFriendShip) or die(mysqli_error($link));
    $friendship = mysqli_fetch_assoc($resFriendship);
}

if (empty($_POST["submit"])) {
} elseif (empty($_POST["content-post"])) {
    $_SESSION["flash"][] = ["status" => false, "text" => "Please write content post to public!"];
} else {
    if (empty($_FILES["post"]["name"])) {
        $contentPost = $_POST["content-post"];

        $insertPostQuery = "INSERT INTO posts SET user_id='$idProfileView', creator_user_id='$id_user_own', content='$contentPost'";
        mysqli_query($link, $insertPostQuery) or die(mysqli_error($link));
        $_SESSION["flash"][] = ["status" => true, "text" => "Post successful published!"];
        header("Refresh:0");
        die();
    } else {
        $targetDir = "img/posts/";
        $fileName = basename($_FILES["post"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

        if (!in_array($fileType, $allowTypes)) {
            $_SESSION["flash"][] = ["status" => false, "text" => "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload."];
        } elseif (!move_uploaded_file($_FILES["post"]["tmp_name"], $targetFilePath)) {
            $_SESSION["flash"][] = ["status" => false, "text" => "Sorry, there was an error uploading your file."];
        } else {

            $contentPost = $_POST["content-post"];

            $insertPostQuery = "INSERT INTO posts SET img_name='$fileName', user_id='$idProfileView', creator_user_id='$id_user_own', content='$contentPost'";
            mysqli_query($link, $insertPostQuery) or die(mysqli_error($link));
            $_SESSION["flash"][] = ["status" => true, "text" => "Post successful published!"];
            header("Refresh:0");
            die();
        }
    }
}
// create post

ob_start();
include "html/create-post-form.php";
$createPostForm = ob_get_clean();

// posts list

$queryGetPosts = "SELECT posts.* FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE users.login='$loginProfileView' ORDER BY id DESC";
$resPosts = mysqli_query($link, $queryGetPosts) or die(mysqli_error($link));
for ($posts = []; $post = mysqli_fetch_assoc($resPosts); $posts[] = $post);

ob_start();
include "html/htmlProfile.php";
$content = ob_get_clean();


return [
    "contentTitle" => "Profile",
    "title" => "Profile",
    "content" => $content
];
