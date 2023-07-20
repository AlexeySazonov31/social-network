<style>
    .infoProfile {
        position: sticky;
        top: 80px;
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
            position: static!important;
        }
    }
</style>
<?php

if (empty($_SESSION["auth"]) or empty($_SESSION["login"])) {
    $_SESSION["flash"][] = "First you need to log in!";
    header("Location: /");
    die();
}

$loginProfileView = $params["login"];
$idProfileView = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$loginProfileView'")))["id"];

$login_user_own = $_SESSION["login"];
$id_user_own = (mysqli_fetch_assoc(mysqli_query($link, "SELECT id FROM users WHERE login='$login_user_own'")))["id"];

$own = $params["login"] === $_SESSION["login"] ? true : false;

$query = "SELECT name, surname, login, email, avatar_name FROM users WHERE login='$loginProfileView'";
$res = mysqli_query($link, $query) or die(mysqli_error($link));
$data = mysqli_fetch_assoc($res);


$content = '<div class="d-flex profilePrimContainer"><div class="infoProfile" style="width: 45%;">';

if ($data["avatar_name"]) {
    $content .= '<img class="mb-5 avatar" src="../../img/avatars/' . $data["avatar_name"] . '" alt="profile icon" />';
} else {
    $content .= '<img class="mb-5 avatar" src="https://cdn-icons-png.flaticon.com/512/1144/1144709.png" alt="profile icon" />';
}

foreach ($data as $key => $value) {
    if ($value and $key !== "avatar_name") {
        $content .= "<h6 class='mt-4 fw-normal'><b>" . ucfirst($key) . ":</b> $value<h6>";
    }
}


if ($own) {
    ob_start();
    include "html/buttons-edit-pass-delete.php";
    $buttonsOwn = ob_get_clean();
    $content .= $buttonsOwn;
}

$content .= "</div><div class='postsProfile' style='width: 55%;'>";

if (empty($_POST["submit"])) {
} elseif (empty($_POST["content-post"])) {
    $_SESSION["flash"][] = "Please write content post to public!";
} else {
    if (empty($_FILES["post"]["name"])) {
        $contentPost = $_POST["content-post"];

        $insertPostQuery = "INSERT INTO posts SET user_id='$idProfileView', creator_user_id='$id_user_own', content='$contentPost'";
        mysqli_query($link, $insertPostQuery) or die(mysqli_error($link));
        $_SESSION["flash"][] = "Post successful published!";
        header("Refresh:0");
        die();
    } else {
        $targetDir = "img/posts/";
        $fileName = basename($_FILES["post"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

        if (!in_array($fileType, $allowTypes)) {
            $_SESSION["flash"][] = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        } elseif (!move_uploaded_file($_FILES["post"]["tmp_name"], $targetFilePath)) {
            $_SESSION["flash"][] = "Sorry, there was an error uploading your file.";
        } else {

            $contentPost = $_POST["content-post"];

            $insertPostQuery = "INSERT INTO posts SET img_name='$fileName', user_id='$idProfileView', creator_user_id='$id_user_own', content='$contentPost'";
            mysqli_query($link, $insertPostQuery) or die(mysqli_error($link));
            $_SESSION["flash"][] = "Post successful published!";
            header("Refresh:0");
            die();
        }
    }
}
// create post

ob_start();
include "html/create-post-form.php";
$createPostForm = ob_get_clean();
$content .= $createPostForm;

// posts list

$queryGetPosts = "SELECT posts.* FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE users.login='$loginProfileView' ORDER BY id DESC";
$resPosts = mysqli_query($link, $queryGetPosts) or die(mysqli_error($link));
for ($posts = []; $post = mysqli_fetch_assoc($resPosts); $posts[] = $post);
if (!empty($posts)) {
    $amountPost = count($posts);
    $content .= "<h3>$amountPost Posts</h3>";
    foreach ($posts as $post) {
        ob_start();
        include "html/post.php";
        $post = ob_get_clean();
        $content .= $post;
    }
}

$content .= "</div>";

return [
    "contentTitle" => "Profile",
    "title" => "Profile",
    "content" => $content
];
