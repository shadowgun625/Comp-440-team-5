<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
	<p>
        <a href="initalDB.php" class="btn btn-danger">Initalize database</a>
    </p>
	<p>
        <a href="blog.php" class="btn btn-danger">Insert Blog</a>
    </p>
    <p>
        <a href="search.php" class="btn btn-danger">Start Search</a>
    </p>

    <hr>
    <h1>Queries</h1>

    <div class="page-body">
		<p>
            <a href="part3_2.php" class="btn btn-danger">List the users who post at least two blogs, one has a tag of “X,” and another has a tag of “Y”.</a>
        </p>
        <p>
            <a href="part3_3.php" class="btn btn-danger">All blogs of a user with positve comments only</a>
        </p>
		<p>
            <a href="part3_4.php" class="btn btn-danger">Max post on date choosen.</a>
        </p>
		<p>
            <a href="part3_5.php" class="btn btn-danger">Find the leaders</a>
        </p>
        <p>
            <a href="part3_6.php" class="btn btn-danger">All users that never posted a blog</a>
        </p>
		<p>
            <a href="part3_7.php" class="btn btn-danger">All users that never posted a comment</a>
        </p>
		<p>
            <a href="part3_8.php" class="btn btn-danger">All users that only post negative comments</a>
        </p>
		<p>
            <a href="part3_9.php" class="btn btn-danger">users who have no negative comments</a>
        </p>
		<p>
            <a href="part3_10.php" class="btn btn-danger">user pairs that gave each other only positive comments</a>
        </p>
    </div>
</body>
</html>