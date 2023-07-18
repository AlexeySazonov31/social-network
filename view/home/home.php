<?php

if( empty($_SESSION["auth"])  ){
    $content = 'Please <a href="/signup">Sign Up</a> or <a href="/login">Login</a> to view Questions!';
} else {
    $content = '<a href="/questions">questions page</a>';
}

return [
    "contentTitle" => "Home Page",
    "title" => "Home Page",
    "content" => $content,
]
?>