<?php
// Initialize the session
session_start();
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 15px sans-serif; text-align: center;}
		.wrapper{ width: 500px; margin: auto;}
    </style>

</head>
<body>
    <div class="wrapper">
        <h1>All the users that never posted a blog</h1>
		<div class="wrapper">
		<?php
		$sql ="SELECT username FROM users WHERE username NOT IN (SELECT postuser FROM blogs)";

		//Group By blogid HAVING SUM(comment.sentiment = 'negative') = 0 ;
		if($stmt = $link -> prepare ($sql)){
			$stmt -> execute();
			$stmt -> bind_result($username);
			while($stmt -> fetch())
			{
				echo '<div class="wrapper">' ;
				echo "<h3>USER: $username</h3>";
				echo '</div>';
			}  
		}
		?>
       
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<a href="welcome.php" class="btn btn-danger">Go Back</a>
			</div>
			
        </form>
</div>