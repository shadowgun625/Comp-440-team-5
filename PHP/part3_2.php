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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }.wrapper{ width: 350px; margin: auto; }
    </style>

</head>
<body>
<div class="wrapper">
<h1>All users who post two blogs and have diffrent tags</h1>
<?php
//$sql = "SELECT DISTINCT postuser FROM blogs, blogstags WHERE (blogs.postuser = blogs.postuser AND blogstags.tag = 'Y') AND (blogs.postuser = blogs.postuser AND blogstags.tag = 'X')" ;
$sql = "SELECT DISTINCT postuser FROM blogs, blogstags WHERE postuser IN (SELECT postuser FROM blogs, blogstags WHERE (blogs.blogid=blogstags.blogid AND blogstags.tag = 'Y')) AND (blogs.blogid=blogstags.blogid AND blogstags.tag = 'X')";

if ($stmt = $link->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($postuser,);
    while ($stmt->fetch()) {
            echo '<div class = "wrapper">';
			echo "<h3>User: $postuser</h3>";
			echo '</div>';
    }
    $stmt->close();
}

?>
    <p>
        <a href="welcome.php" class="btn btn-danger">Go back</a>
    </p>
	</div>

</body>
</html>