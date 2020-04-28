<?php
// Initialize the session
session_start();

// Include config file
require_once "config.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
} 

//$sql = "SELECT DISTINCT postuser FROM blogs, blogstags WHERE (blogs.postuser = blogs.postuser AND blogstags.tag = 'Y') AND (blogs.postuser = blogs.postuser AND blogstags.tag = 'X')" ;
$sql = "SELECT DISTINCT postuser FROM blogs, blogstags WHERE (blogstags.tag = 'Y') AND (blogstags.tag = 'X')";

if ($stmt = $link->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($postuser,);
    while ($stmt->fetch()) {
            printf("%s\n", $postuser);
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }.wrapper{ width: 350px; padding: 20px; }
    </style>

</head>
<body>
    <p>
        <a href="welcome.php" class="btn btn-danger">Go back</a>
    </p>

</body>
</html>