<?php
// Initialize the session
session_start();
require_once "config.php";

$sql ="SELECT username FROM users WHERE username NOT IN (SELECT author FROM comments)";

//Group By blogid HAVING SUM(comment.sentiment = 'negative') = 0 ;
if($stmt = $link -> prepare ($sql)){
    $stmt -> execute();
    $stmt -> bind_result($username);
    while($stmt -> fetch())
    {
        echo "<br>" ;
        printf("Username: %s\n", $username);
    }  
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 15px sans-serif; text-align: center;}
		.wrapper{ width: 500px; margin: auto;}
    </style>

</head>
<body>


    <div class="wrapper">
        <h1>All the users that never made a comment</h1>
  <div class="wrapper">
       
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<a href="welcome.php" class="btn btn-danger">Go Back</a>
			</div>
			
        </form>
</div>