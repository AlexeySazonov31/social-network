<?php

if( empty($_SESSION["auth"])  ){
    $content = 'Please <a href="/signup">Sign Up</a> or <a href="/login">Login</a> to view Questions!';
} else {
    $content = 'Home Page';
}

return [
    "contentTitle" => "Home Page",
    "title" => "Home Page",
    "content" => $content,
]
?>