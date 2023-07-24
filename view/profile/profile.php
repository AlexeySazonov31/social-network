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

$query = "SELECT name, surname, login, email, avatar_name FROM users WHERE login='$loginProfileView'";
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


$content = '<div class="d-flex profilePrimContainer"><div class="infoProfile" style="width: 33.3%;">';

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
$queryCountFriends = "SELECT count(*) as count 
from friends 
where
user_id_1='$id_user_own'
or
user_id_2='$id_user_own'";
$resCountFriends = mysqli_query($link, $queryCountFriends) or die(mysqli_error($link));
$countFriends = mysqli_fetch_assoc($resCountFriends);
$content .= "<h6 class='mt-4 fw-normal'><b>Friends: </b>$countFriends[count]<h6>";

if (!$own) {
    $querySearchFriendShip = "SELECT * 
    from friends 
    WHERE 
    (user_id_1='$id_user_own' and user_id_2='$idProfileView')
    or
    (user_id_2='$id_user_own' and user_id_1='$idProfileView')";
    $resFriendship = mysqli_query($link, $querySearchFriendShip) or die(mysqli_error($link));
    $friendship = mysqli_fetch_assoc($resFriendship);

    $content .= "<br>";
    if (empty($friendship)) {
        $content .= "<a href='/friends/add/$idProfileView'>ADD FRIEND</a>";
    } elseif ($friendship["status"]) {
        $content .= "<p class='text-success'>your friend</p>";
        // message
        $content .= "<a href='/messenger/$loginProfileView' class='text-primary'>messenger</a><br><br>";
        // -------
        $content .= "<a href='/friends/delete/$idProfileView' class='text-danger'>delete friend</a>";
    } elseif ($friendship["user_id_1"] === $id_user_own) {
        $content .= "<p class='text-success'>!friendship requested!</p><br>";
        $content .= "<a href='/friends/delete/$idProfileView' class='text-danger'>delete request</a>";
    } else {
        $content .= "<a href='/friends/confirm/$idProfileView' class='text-success'>confirm friendship</a><br><br>";
        $content .= "<a href='/friends/delete/$idProfileView' class='text-danger'>refuse</a>";
    }
}


if ($own) {
    ob_start();
    include "html/buttons-edit-pass-delete.php";
    $buttonsOwn = ob_get_clean();
    $content .= $buttonsOwn;
}

$content .= "</div><div class='postsProfile' style='width: 66.7%;'>";

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
